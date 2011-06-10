using System;
using System.Collections.Generic;
using System.Text;
using System.Data.SQLite;
using System.IO;


namespace MSNSend
{
    public class Sqlite3
    {
        private string dbFile;
        private SQLiteConnection conn = null;
        public Sqlite3(string filename)
        {
            this.dbFile = filename;
            conn = new SQLiteConnection(string.Format("Data Source={0}", filename));
            conn.Open();
            this.Create();
        }

        public void Create()
        {
            //conn.BeginTransaction();
            SQLiteCommand cmd = conn.CreateCommand();
            cmd.CommandText = "create table if not exists user(name varchar(100))";
            cmd.ExecuteNonQuery();
        }

        public void Insert(string name)
        {
            SQLiteCommand cmd = conn.CreateCommand();
            cmd.CommandText = string.Format("insert into user (name) values('{0}')", name);
            cmd.ExecuteNonQuery();
        }

        public bool ContainsKey(string name)
        {
            SQLiteCommand cmd = conn.CreateCommand();
            cmd.CommandText = string.Format("select count(*) from user where name = '{0}'", name);
            if (cmd.ExecuteScalar().ToString() == "0")
            {
                return false;
            }
            return true;
        }
    }
}
