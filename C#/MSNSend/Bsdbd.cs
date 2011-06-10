using System;
using System.Collections.Generic;
using System.Text;
using BerkeleyDb;
using BerkeleyDb.Serialization;
using Kds.Serialization;
using Kds.Serialization.Buffer;
using System.IO;
namespace MSNSend
{
    public class Bsdbd
    {
        /// <summary>
        /// 数据库目录
        /// </summary>
        private string directory;
        /// <summary>
        /// 数据库文件名
        /// </summary>
        private string dbName;

        private DbHash btree;
        private Txn txn;
        private Db db;
        private Env env;
        MemoryStream dataStream = new MemoryStream();
        /// <summary>
        /// 初始化
        /// </summary>
        private void Init()
        {
            
            env = new Env(EnvCreateFlags.None);
            Env.OpenFlags envFlags =
            Env.OpenFlags.Create |
            Env.OpenFlags.InitLock |
            Env.OpenFlags.InitLog |
            Env.OpenFlags.InitMPool |
            Env.OpenFlags.InitTxn |
            Env.OpenFlags.Recover;
            env.Open(directory, envFlags, 0);
            txn = env.TxnBegin(null, Txn.BeginFlags.None);
            db = env.CreateDatabase(DbCreateFlags.None);
            btree = (DbHash)db.Open(txn, dbName, null, DbType.Hash, Db.OpenFlags.Create, 0);
        }

        public int Capacity
        {
            get
            {
                return dataStream.Capacity;
            }
            set
            {
                dataStream.Capacity = value;
            }
        }

        public Bsdbd(string name)
        {
            this.dbName = name;
            dataStream.Capacity = 100;
            this.Init();
        }

        public string this[string key]
        {
            get
            {
                DbEntry keyEntry = DbEntry.InOut(Encoding.Default.GetBytes(key));
                DbEntry dataEntry = DbEntry.InOut(dataStream.GetBuffer());
                ReadStatus res = btree.Get(txn, ref keyEntry, ref dataEntry, DbFile.ReadFlags.None);
                return Encoding.Default.GetString(dataEntry.Buffer, 0, dataEntry.Size);
            }
            set
            {
                DbEntry keyEntry = DbEntry.InOut(Encoding.Default.GetBytes(key));
                DbEntry dataEntry = DbEntry.InOut(Encoding.Default.GetBytes(value));
                WriteStatus res = btree.Put(txn, ref keyEntry, ref dataEntry);
            }
        }

        public bool ContainsKey(string key)
        {
            DbEntry keyEntry = DbEntry.InOut(Encoding.Default.GetBytes(key));
            DbEntry dataEntry = DbEntry.InOut(dataStream.GetBuffer());
            ReadStatus res = btree.Get(txn, ref keyEntry, ref dataEntry, DbFile.ReadFlags.None);
            return res == ReadStatus.NotFound;
        }

        public bool Delete(string key)
        {
            DbEntry keyEntry = DbEntry.InOut(Encoding.Default.GetBytes(key));
            DeleteStatus res = btree.Delete(txn, ref keyEntry);
            return res == DeleteStatus.Success;
        }

        public void Sync()
        {
            btree.Sync();
        }
        public void Close()
        {
            this.Sync();
            btree.GetDb().Close();
        }
    }
}
