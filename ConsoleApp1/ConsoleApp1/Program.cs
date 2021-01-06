using System.Threading;

namespace GoogleDrive
{
    class Program
    {
        private const int UpdateDelay = 2000;
        static void Main(string[] args)
        {
            GoogleDriveController.Init();
            while (true)
            {
                Thread.Sleep(UpdateDelay);
                GoogleDriveController.CheckUpdate();
            }
        }
    }
}