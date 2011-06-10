using System;
using System.Collections.Generic;
using System.Text;
using System.Data.OleDb;
using System.Data;
using System.IO;
using System.Configuration;
namespace TTwait
{

	public class ConnStringHelp
	{
		protected string dataSource = "";

		public string DataSource
		{
			get { return dataSource; }
			set { dataSource = value; }
		}

		protected string initDataBase = "";

		public string InitDataBase
		{
			get { return initDataBase; }
			set { initDataBase = value; }
		}

		protected string uid = "";

		public string Uid
		{
			get { return uid; }
			set { uid = value; }
		}

		protected string password = "";

		public string Password
		{
			get { return password; }
			set { password = value; }
		}

		public virtual string ToString(){return "";}
	}

	public class SQLHelp:ConnStringHelp
	{
		
		public override string ToString()
		{
			return string.Format("Provider=SQLOLEDB;Data Source=({0});Initial Catalog={1};Integrated Security=SSPI;uid={2};password={3}", dataSource, initDataBase, uid, password);
		}
	}

	public class ExcelHelp:ConnStringHelp
	{

		public override string ToString()
		{
			return string.Format("provider=Microsoft.Jet.OLEDB.4.0;data source={0};Extended Properties=Excel 8.0;", dataSource);
		}
	}

	public class AccessHelp :ConnStringHelp
	{

		public override string ToString()
		{
			return string.Format("Provider=Microsoft.Jet.OLEDB.4.0; Data Source={0};User ID=;Password=", dataSource);
		}
	}
	/// <summary>
	/// 数据库连接示例：
	/// Access: Provider=Microsoft.Jet.OLEDB.4.0; Data Source=d:\Northwind.mdb;User ID=Admin;Password=; 
	/// SQL:Provider=MSDataShape;Data Provider=SQLOLEDB;Data Source=(local);Initial Catalog=pubs;Integrated Security=SSPI;uid=sa;password=841013
	/// Excel:Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\MyExcel.xls;Extended Properties=""Excel 8.0;HDR=Yes;IMEX=1""
	/// </summary>
	public class DataAccess
	{	
		private string connStr = "";
		string filename = "";
		bool EnabelLog
		{
			get 
			{
				if(filename == "")
				{
					filename = ConfigurationSettings.AppSettings["sqlLogger"];
				}
				if (filename == null)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		public string ConnStr
		{
			set { connStr = value; }
			get { return connStr; }
		}

		public void LogSql(string sql)
		{
			if (EnabelLog)
			{
				if (sql.StartsWith("select", true,null))
					return;
                else if (sql.StartsWith("insert into category", true, null))
                {
                    string newsql = "select top 1 id from category order by id desc";
                    int id = int.Parse(this.ExecuteScalar(newsql).ToString()) + 1;
                    sql = sql.Replace("(name", "(id, name");
                    sql = sql.Replace("values(", string.Format("values({0},", id));
                }
                else if (sql.StartsWith("insert into hw", true, null))
                {
                    string newsql = "select top 1 hw_id from hw order by hw_id desc";
                    int id = int.Parse(this.ExecuteScalar(newsql).ToString()) + 1;
                    sql = sql.Replace("(hw_name", "(hw_id, hw_name");
                    sql = sql.Replace("values(", string.Format("values({0},", id));
                }
                File.AppendAllText(filename, sql+";\r\n");
                
			}
		}

		public DataAccess()
		{
		}

		public DataAccess(string connectStr)
		{
			this.ConnStr = connectStr;
		}

		public DataAccess(ConnStringHelp cshlep)
		{
			this.ConnStr = cshlep.ToString();
		}
		

		/// <summary>
		/// 执行SQL语句，返回影响的记录数
		/// </summary>
		/// <param name="SQLString"></param>
		/// <returns></returns>
		public int Execute(string SQLString, bool log)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				using (OleDbCommand cmd = new OleDbCommand(SQLString, connection))
				{
					try
					{
						connection.Open();
						int rows = cmd.ExecuteNonQuery();
                        if(log)
						    LogSql(SQLString);
						return rows;
					}
					catch (OleDbException E)
					{
						throw new Exception(E.Message);
					}
				}
			}
		}

        public int Execute(string SQLString)
        {
            return Execute(SQLString, true);
        }

		/// <summary>
		/// 执行两条SQL语句，实现数据库事务。
		/// </summary>
		/// <param name="SQLString1"></param>
		/// <param name="SQLString2"></param>
		public void ExecuteSqlTran(string SQLString1, string SQLString2)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				connection.Open();
				OleDbCommand cmd = new OleDbCommand();
				cmd.Connection = connection;
				OleDbTransaction tx = connection.BeginTransaction();
				cmd.Transaction = tx;
				try
				{
					cmd.CommandText = SQLString1;
					cmd.ExecuteNonQuery();
					cmd.CommandText = SQLString2;
					cmd.ExecuteNonQuery();
					tx.Commit();
					LogSql(SQLString1);
					LogSql(SQLString2);
				}
				catch (System.Data.SqlClient.SqlException E)
				{
					tx.Rollback();
					throw new Exception(E.Message);
				}
				finally
				{
					cmd.Dispose();
					connection.Close();
				}
			}
		}


		/// <summary>
		/// 执行多条SQL语句，实现数据库事务，每条语句以“;”分割。
		/// </summary>
		/// <param name="SQLStringList"></param>
		public void ExecuteSqlTran(string SQLStringList)
		{
			using (OleDbConnection conn = new OleDbConnection(connStr))
			{
				conn.Open();
				OleDbCommand cmd = new OleDbCommand();
				cmd.Connection = conn;
				OleDbTransaction tx = conn.BeginTransaction();
				cmd.Transaction = tx;
				try
				{
					string[] split = SQLStringList.Split(new Char[] { ';' });
					foreach (string strsql in split)
					{
						if (strsql.Trim() != "")
						{
							cmd.CommandText = strsql;
							cmd.ExecuteNonQuery();
						}
					}
					tx.Commit();
					foreach (string sql in split)
					{
						LogSql(sql);
					}
				}
				catch (System.Data.Odbc.OdbcException E)
				{
					tx.Rollback();
					throw new Exception(E.Message);
				}
			}
		}

		/// <summary>
		/// 执行带一个存储过程参数的的SQL语句。
		/// </summary>
		/// <param name="SQLString"></param>
		/// <param name="content"></param>
		/// <returns></returns>
		public int Execute(string SQLString, string content)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbCommand cmd = new OleDbCommand(SQLString, connection);
				OleDbParameter myParameter = new OleDbParameter("@content", SqlDbType.NText);
				myParameter.Value = content;
				cmd.Parameters.Add(myParameter);
				try
				{
					connection.Open();
					int rows = cmd.ExecuteNonQuery();
					return rows;
				}
				catch (OleDbException E)
				{
					throw new Exception(E.Message);
				}
				finally
				{
					cmd.Dispose();
					connection.Close();
				}
			}
		}

		/// <summary>
		/// 向数据库里插入图像格式的字段
		/// </summary>
		/// <param name="strSQL"></param>
		/// <param name="fs"></param>
		/// <returns></returns>
		public int ExecuteInsertImg(string strSQL, byte[] fs)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbCommand cmd = new OleDbCommand(strSQL, connection);
				OleDbParameter myParameter = new OleDbParameter("@fs", SqlDbType.Image);
				myParameter.Value = fs;
				cmd.Parameters.Add(myParameter);
				try
				{
					connection.Open();
					int rows = cmd.ExecuteNonQuery();
					return rows;
				}
				catch (OleDbException E)
				{
					throw new Exception(E.Message);
				}
				finally
				{
					cmd.Dispose();
					connection.Close();
				}

			}
		}

		/// <summary>
		/// 执行一条计算查询结果语句，返回查询结果（整数）。
		/// </summary>
		/// <param name="strSQL"></param>
		/// <returns></returns>
		public int ExecuteInt(string strSQL)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbCommand cmd = new OleDbCommand(strSQL, connection);
				try
				{
					connection.Open();
					OleDbDataReader result = cmd.ExecuteReader();
					int i = 0;
					while (result.Read())
					{
						i = result.GetInt32(0);
					}
					result.Close();
					LogSql(strSQL);
					return i;
				}
				catch (OleDbException e)
				{
					throw new Exception(e.Message);
				}
				finally
				{
					cmd.Dispose();
					connection.Close();
				}
			}
		}

		/// <summary>
		/// 执行一条计算查询结果语句，返回查询结果（字符串）。
		/// </summary>
		/// <param name="strSQL"></param>
		/// <returns></returns>
		public string ExecuteString(string strSQL)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbCommand cmd = new OleDbCommand(strSQL, connection);
				try
				{
					connection.Open();
					OleDbDataReader result = cmd.ExecuteReader();
					string i = "";
					while (result.Read())
					{
						i = result.GetString(0);
					}
					result.Close();
					LogSql(strSQL);
					return i;
				}
				catch (OleDbException e)
				{
					throw new Exception(e.Message);
				}
				finally
				{
					cmd.Dispose();
					connection.Close();
				}
			}
		}
		/// <summary>
		/// 执行一条计算查询结果语句，返回查询结果（object）。
		/// </summary>
		/// <param name="SQLString"></param>
		/// <returns></returns>
		public object ExecuteScalar(string SQLString)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbCommand cmd = new OleDbCommand(SQLString, connection);
				try
				{
					connection.Open();
					object obj = cmd.ExecuteScalar();
					if ((Object.Equals(obj, null)) || (Object.Equals(obj, System.DBNull.Value)))
					{
						return null;
					}
					else
					{
						return obj;
					}
				}
				catch (OleDbException e)
				{
					throw new Exception(e.Message);
				}
				finally
				{
					LogSql(SQLString);
					cmd.Dispose();
					connection.Close();
				}
			}
		}

		/// <summary>
		/// 执行查询语句，返回SqlDataReader
		/// </summary>
		/// <param name="strSQL"></param>
		/// <returns></returns>
		public OleDbDataReader ExecuteReader(string strSQL)
		{
			OleDbConnection connection = new OleDbConnection(connStr);
			//{
				OleDbCommand cmd = new OleDbCommand(strSQL, connection);
				OleDbDataReader myReader;
				try
				{
					connection.Open();
					myReader = cmd.ExecuteReader();
					return myReader;
				}
				catch (OleDbException e)
				{
					cmd.Dispose();
					connection.Close();
					throw new Exception(e.Message);
				}
			//}
		}

		/// <summary>
		/// 执行查询语句，返回DataSet
		/// </summary>
		/// <param name="SQLString"></param>
		/// <returns></returns>
		public DataSet ExecuteDataSet(string SQLString)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				DataSet ds = new DataSet();
				try
				{
					connection.Open();
					OleDbDataAdapter command = new OleDbDataAdapter(SQLString, connection);
					command.Fill(ds, "ds");
				}
				catch (OleDbException ex)
				{
					throw new Exception(ex.Message);
				}
				return ds;
			}

		}

		public DataTable ExecuteDataTable(string SQLString)
		{
			return ExecuteDataSet(SQLString).Tables[0];
		}


		#region 存储过程操作

		/// <summary>
		/// 运行存储过程
		/// </summary>
		/// <param name="storedProcName"></param>
		/// <param name="parameters"></param>
		/// <returns></returns>
		public OleDbDataReader RunProcedure(string storedProcName, IDataParameter[] parameters)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				OleDbDataReader returnReader;
				connection.Open();
				OleDbCommand command = BuildQueryCommand(connection, storedProcName, parameters);
				command.CommandType = CommandType.StoredProcedure;

				returnReader = command.ExecuteReader();
				//Connection.Close();
				return returnReader;
			}
		}

		private OleDbCommand BuildQueryCommand(OleDbConnection connection, string storedProcName, IDataParameter[] parameters)
		{

			OleDbCommand command = new OleDbCommand(storedProcName, connection);
			command.CommandType = CommandType.StoredProcedure;
			foreach (OleDbParameter parameter in parameters)
			{
				command.Parameters.Add(parameter);
			}
			return command;

		}

		public DataSet RunProcedure(string storedProcName, IDataParameter[] parameters, string tableName)
		{
			using (OleDbConnection connection = new OleDbConnection(connStr))
			{
				DataSet dataSet = new DataSet();
				connection.Open();
				OleDbDataAdapter sqlDA = new OleDbDataAdapter();
				sqlDA.SelectCommand = BuildQueryCommand(connection, storedProcName, parameters);
				sqlDA.Fill(dataSet, tableName);
				connection.Close();

				return dataSet;
			}
		}

		#endregion

	}
}