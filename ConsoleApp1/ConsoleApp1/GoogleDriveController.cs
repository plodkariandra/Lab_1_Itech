using Google.Apis.Auth.OAuth2;
using Google.Apis.Drive.v3;
using Google.Apis.Services;
using Google.Apis.Util.Store;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading;
using File = Google.Apis.Drive.v3.Data.File;

namespace GoogleDrive
{
    static class GoogleDriveController
    {
        static string[] Scopes = { DriveService.Scope.DriveReadonly };
        static string ApplicationName = "Drive API .NET Quickstart";
        private static UserCredential credential;
        private static List<File> serverFilesList;
        private static DriveService driveService;

        private const string SyncFolderPath = @"C:\Users\Lenovo\source\repos\ConsoleApp1\ConsoleApp1\Sync";

        public static void Init()
        {
            using (var stream =
                new FileStream(@"C:\Users\Lenovo\source\repos\ConsoleApp1\ConsoleApp1\credentials.json", FileMode.Open, FileAccess.Read))
            {
                string credPath = "token.json";
                credential = GoogleWebAuthorizationBroker.AuthorizeAsync(
                    GoogleClientSecrets.Load(stream).Secrets,
                    Scopes,
                    "user",
                    CancellationToken.None,
                    new FileDataStore(credPath, true)).Result;
            }
            driveService = GetDriveService();
            GetFilesFromServer();
            ShowServerFiles();
        }

        private static DriveService GetDriveService()
        {
            return new DriveService(new BaseClientService.Initializer()
            {
                HttpClientInitializer = credential,
                ApplicationName = ApplicationName,
            });
        }

        private static void GetFilesFromServer()
        {
            FilesResource.ListRequest listRequest = driveService.Files.List();
            listRequest.Fields = "nextPageToken, files(id, size, name)";
            listRequest.Q = "trashed = false";
            IList<File> files = listRequest.Execute()
                .Files;
            serverFilesList = new List<File>(files);
        }

        private static void ShowServerFiles()
        {
            Console.WriteLine("Files:");
            if (serverFilesList != null && serverFilesList.Count > 0)
            {
                foreach (var file in serverFilesList)
                {
                    Console.WriteLine("{0} ({1})", file.Name, file.Size);
                }
            }
            else
            {
                Console.WriteLine("No files found.");
            }
        }

        public static void CheckUpdate()
        {
            GetFilesFromServer();
            List<string> localFilesNamesList = new List<string>(new DirectoryInfo(SyncFolderPath).GetFiles().Select(t => t.Name).ToList());
            foreach (var serverFile in serverFilesList)
            {
                if (!localFilesNamesList.Contains(serverFile.Name))
                {
                    DownloadFile(serverFile.Id, serverFile.Name);
                }
            }

            var serverFilesNamesList = serverFilesList.Select(t => t.Name).ToList();
            foreach (var localFile in localFilesNamesList)
            {
                if (!serverFilesNamesList.Contains(localFile))
                {
                    System.IO.File.Delete(Path.Combine(SyncFolderPath, localFile));
                }
            }
        }

        private static void DownloadFile(string id, string fileName)
        {
            var request = driveService.Files.Get(id);
            using (var memoryStream = new MemoryStream())
            {
                request.Download(memoryStream);
                using (var fileStream = new FileStream(Path.Combine(SyncFolderPath, fileName), FileMode.Create, FileAccess.Write))
                {
                    fileStream.Write(memoryStream.GetBuffer(), 0, memoryStream.GetBuffer().Length);
                }
            }
        }

        private static string UploadFile(string fileName, string filePath, string ContentType)
        {
            var fileMetaData = new File();
            fileMetaData.Name = fileName;
            FilesResource.CreateMediaUpload request;
            using (var stream = new FileStream(filePath, FileMode.Open))
            {
                request = driveService.Files.Create(fileMetaData, stream, ContentType);
                request.Upload();
            }

            var file = request.ResponseBody;
            return file.Id;
        }
    }
}