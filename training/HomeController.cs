using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Web.Script.Serialization;
using System.Web.Services;

namespace MicahToDo.Controllers
{
    public class HomeController : Controller
    {
        public ActionResult Index()
        {
            return View();
        }

        public ActionResult About()
        {
            ViewBag.Message = "Your application description page.";

            return View();
        }

        public ActionResult Contact()
        {
            ViewBag.Message = "Your contact page.";

            return View();
        }

        public ActionResult Micah()
        {
            ViewBag.Message = "Your Name.";
          
            return View();
        }

        public List<string> list = new List<string>();
        public JsonResult GetToDoList()
        {
            list.Add("Clean Room");
            list.Add("Clean Car");
            list.Add("Apply to Jobs");
            return Json(list, JsonRequestBehavior.AllowGet);
        }

        [HttpPost]
        public JsonResult PostToDoList(string value)
        {
            //return DateTime.Now.ToString();
            list.Add(value);
            return Json(value, JsonRequestBehavior.AllowGet);
        }
    }
}