using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace Practice
{
    class addUser
    {
        public addUser(string firstName, string lastName, string accountType) {
            var password = generatePassword();
            var userName = firstName[0] + lastName;
            userName = userName.ToLower();
            if (accountType == "a")
            {
                accountType = "admin";
            }
            else
            {
                accountType = "associate";
            }
            string connstring = @"Server = localhost; Port=3306; Database = test; Uid = root; Pwd = password;";
            MySqlConnection conn = null;
            conn = new MySqlConnection(connstring);
            conn.Open();

            var query = $"insert into users (first_name, last_name, account_type, username, password) values ('{firstName}', '{lastName}', '{accountType}', '{userName}', '{password}');";
            var cmd = new MySqlCommand(query, conn);
            cmd.ExecuteNonQuery();
        }

        private string generatePassword()
        {
            const int passwordLength = 6;
            var random = new Random(); //class user for generating random numbers
            var passArray = new char[passwordLength];
            for (var i = 0; i < passwordLength; i++)
                passArray[i] = (char)('a' + random.Next(0, 26)); //casting random numbers as characters based on ascii value
            var password = new string(passArray); //creates string from array
            return password;
        }
    }
}
