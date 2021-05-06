using System;
using System.Collections.Generic;
using System.Net;
using System.Net.Mail;
using System.Reflection;
using System.Text.RegularExpressions;
using System.Threading;
using Newtonsoft.Json;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;

    public class Program
    {
        private static IWebDriver driver;
        private static Dictionary<Date, WeatherData> weatherDataDictionary = new Dictionary<Date, WeatherData>();

        #region Constants
        private const int MinWindSpeed = 4;
        private const int MaxWindSpeed = 7;
        private const int MinWindDegree = 180;
        private const int MaxWindDegree = 200;
        private const string NotificationMail = "karina.vrakina@nure.ua";
        private const string WeatherUrl = "https://www.windguru.cz/87721";
        private const int PageLoadingDelay = 2500;
        private static readonly Date DateNowDebug = new Date(6,3); //DefaultValue = null
        #endregion
        
        private static void Main(string[] args)
        {
            driver = new ChromeDriver();
            driver.Navigate().GoToUrl(WeatherUrl);
            Thread.Sleep(PageLoadingDelay);
            driver.Manage().Timeouts().PageLoad = TimeSpan.FromSeconds(5);
            IJavaScriptExecutor js = (IJavaScriptExecutor)driver;
            string result = (string)js.ExecuteScript("let dates = []; let wspeed = []; let wgust = []; let degree = []; let info = []; Array.from(document.getElementById('tabid_0_0_dates').getElementsByTagName('td')).forEach(el => { dates.push(el.innerText); }); Array.from(document.getElementById('tabid_0_0_WINDSPD').getElementsByTagName('td')).forEach(el => { wspeed.push(el.innerText); }); Array.from(document.getElementById('tabid_0_0_SMER').getElementsByTagName('span')).forEach(el => { degree.push(el.title); }); for (let i=0; i<dates.length; i++) { temp = {}; temp.date = dates[i]; temp.wspeed = wspeed[i]; temp.degree = degree[i]; info.push(temp); } return JSON.stringify(info);");
            driver.Quit();
            UpdateAndCheckInfo(result);
        }

        private static void ParseJson(string dataJson)
        {
            List<WeatherData> weatherDataList = JsonConvert.DeserializeObject<List<WeatherData>>(dataJson);
            weatherDataList.ForEach(x => Console.WriteLine(x));
            foreach (var weatherData in weatherDataList)
            {
                weatherDataDictionary[weatherData.Date] = weatherData;
            }
        }

        private static void UpdateAndCheckInfo(string dataJson)
        {
            ParseJson(dataJson);
            CheckInfo();
        }

        private static void CheckInfo()
        {
            Date dateNow;
            if (DateNowDebug == null)
                dateNow = new Date(DateTime.Now.Day, DateTime.Now.Hour);
            else
            {
                dateNow = DateNowDebug;
            }
            if (weatherDataDictionary.ContainsKey(dateNow))
            {
                WeatherData weatherDataNow = weatherDataDictionary[dateNow];
                if (weatherDataNow.WindSpeed >= MinWindSpeed && weatherDataNow.WindSpeed <= MaxWindSpeed)
                {
                    if (weatherDataNow.WindDegreeNormalized >= MinWindDegree &&
                        weatherDataNow.WindDegreeNormalized <= MaxWindDegree)
                    {
                        SendNotificationToMail();
                    }
                }
            }
        }

        private static void SendNotificationToMail()
        {
            Console.WriteLine(MethodBase.GetCurrentMethod().Name);
            MailAddress from = new MailAddress("somemail@gmail.com", "Weather");
            MailAddress to = new MailAddress(NotificationMail);
            MailMessage m = new MailMessage(from, to);
            m.Subject = "Weather Warning";
            m.Body = "Please stay at home!";
            m.IsBodyHtml = true;
            SmtpClient smtp = new SmtpClient("smtp.gmail.com", 587);
            smtp.Credentials = new NetworkCredential("unitytester2020@gmail.com", "testerunitytester");
            smtp.EnableSsl = true;
            smtp.Send(m);
        }
    }

    [Serializable]
    public class WeatherData
    {
        [JsonProperty("date")] public Date Date { get; private set; }
        [JsonProperty("wspeed")] public int WindSpeed { get; private set; }
        [JsonProperty("degree")] public string WindDegree { get; private set; }
        public int WindDegreeNormalized { get; private set; }

        #region Constants
        private const string RegexWindDegreePattern = @"(\d+)";
        #endregion

        public WeatherData(string date, int windSpeed, string windDegree)
        {
            Date = new Date(date);
            WindSpeed = windSpeed;
            WindDegree = windDegree;
            WindDegreeNormalized = NormalizeWindDegree(windDegree);
        }

        public override string ToString()
        {
            return $"{Date} | {WindSpeed} | {WindDegreeNormalized}";
        }

        private int NormalizeWindDegree(string windDegree)
        {
            Regex regex = new Regex(RegexWindDegreePattern);
            Match match = regex.Match(windDegree);
            return int.Parse(match.Value);
        }
    }
    
    public class Date
    {
        public int Day { get; private set; }
        public int Hour { get; private set; }

        #region Constants
        private const string RegexPattern = @"(\d+)";
        private const int DayIndex = 0;
        private const int HourIndex = 1;
        #endregion

        public Date(string date)
        {
            Regex regex = new Regex(RegexPattern);
            var matches = regex.Matches(date);
            Day = int.Parse(matches[DayIndex].Value);
            Hour = int.Parse(matches[HourIndex].Value);
        }

        public Date(int day, int hour)
        {
            Day = day;
            Hour = hour;
        }

        public override string ToString()
        {
            return $"{Day} {Hour}";
        }

        public override int GetHashCode()
        {
            return int.Parse($"{Day}{Hour}");
        }

        public override bool Equals(object obj)
        {
            return Equals(obj as Date);
        }

        private bool Equals(Date date)
        {
            return Day == date.Day && Hour == date.Hour;
        }
    }