using System;

namespace Practice
{
    class newUser
    {
        public string firstName;
        public string lastName;
        public string accountType;
        public int userId;
        public double salaryHourly;
        public string userName;
        public string password;

        public newUser(string a, string b, string c, int d, double e, string f) //constructor; method name must be same as class
        {
            firstName = a;
            lastName = b;
            accountType = c;
            userId = d;
            salaryHourly = e;
            userName = f;
            password = generatePassword();
        }

        public double payCalc(int a)
        {
            return salaryHourly * a;
        }

        public double yearlySalary()
        {
            return (salaryHourly * 40) * 52;
        }

        private string generatePassword()
        {
            const int passwordLength = 12;
            var random = new Random(); //class user for generating random numbers
            var passArray = new char[passwordLength];
            for (var i = 0; i < passwordLength; i++)
                passArray[i] = (char)('a' + random.Next(0, 26)); //casting random numbers as characters based on ascii value
            var password = new string(passArray); //creates string from array
            return password;
        }
    }
}
