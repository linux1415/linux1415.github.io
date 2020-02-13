using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace Practice
{
    class Authenticate
    {
        public string firstName;
        public string lastName;
        public string accountType;
        public int userId;
        public string status;

        public Authenticate(string username, string password) //constructor; method name must be same as class
        {
            string connstring = @"Server = localhost; Port=3306; Database = test; Uid = root; Pwd = password;";
            MySqlConnection conn = null;
            conn = new MySqlConnection(connstring);
            conn.Open();

            var query = "SELECT username, password, first_name, last_name, account_type, id from users;";
            var cmd = new MySqlCommand(query, conn);
            MySqlDataReader rdr = cmd.ExecuteReader();
            while (rdr.Read())
            {
                if (rdr.GetString(0) == username && rdr.GetString(1) == password)
                {
                    firstName = rdr.GetString(2);
                    lastName = rdr.GetString(3);
                    accountType = rdr.GetString(4);
                    userId = rdr.GetInt32(5);
                    status = "success";
                }
            }
        }
    }
}
