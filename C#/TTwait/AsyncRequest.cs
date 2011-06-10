using System;
using System.Net;
using System.IO;
using System.Text;
using System.Threading;

namespace TTwait
{
	public class RequestState
	{
		// This class stores the state of the request.
		const int BUFFER_SIZE = 1024;
		public StringBuilder requestData;
		public byte[] bufferRead;
		public HttpWebRequest request;
		public HttpWebResponse response;
		public Stream responseStream;
		public RequestState()
		{
			bufferRead = new byte[BUFFER_SIZE];
			requestData = new StringBuilder("");
			request = null;
			responseStream = null;
		}
	}

	class AsyncRequest
	{
		public ManualResetEvent allDone = new ManualResetEvent(false);
		const int BUFFER_SIZE = 1024;
		public string GetString(string url)
		{
			// Create a new webrequest to the mentioned URL.   
			HttpWebRequest myWebRequest = (HttpWebRequest)WebRequest.Create(url);
			myWebRequest.Method = "Get";
			myWebRequest.KeepAlive = true;
			myWebRequest.ContentType = "application/x-www-form-urlencoded";
			myWebRequest.Timeout = 30000;
			myWebRequest.Headers.Add("Pragma", "no-cache");
			// Create a new instance of the RequestState.
			RequestState myRequestState = new RequestState();
			// The 'WebRequest' object is associated to the 'RequestState' object.
			myRequestState.request = myWebRequest;
			// Start the Asynchronous call for response.
			IAsyncResult asyncResult = (IAsyncResult)myWebRequest.BeginGetResponse(new AsyncCallback(RespCallback), myRequestState);
			allDone.WaitOne();
			// Release the WebResponse resource.
			if (myRequestState.response != null)
			{
				myRequestState.response.Close();
			}
			return myRequestState.requestData.ToString();
		}

		public static string GetPage(string url)
		{
			AsyncRequest req = new AsyncRequest();
			return req.GetString(url);
		}
		private void RespCallback(IAsyncResult asynchronousResult)
		{
			try
			{
				// Set the State of request to asynchronous.
				RequestState myRequestState = (RequestState)asynchronousResult.AsyncState;
				HttpWebRequest myWebRequest1 = myRequestState.request;
				// End the Asynchronous response.
				myRequestState.response = (HttpWebResponse)myWebRequest1.EndGetResponse(asynchronousResult);
				// Read the response into a 'Stream' object.
				Stream responseStream = myRequestState.response.GetResponseStream();
				myRequestState.responseStream = responseStream;
				// Begin the reading of the contents of the HTML page and print it to the console.
				IAsyncResult asynchronousResultRead = responseStream.BeginRead(myRequestState.bufferRead, 0, BUFFER_SIZE, new AsyncCallback(ReadCallBack), myRequestState);
			}
			catch (WebException e)
			{
				allDone.Set();
				throw e;
			}
		}
		private void ReadCallBack(IAsyncResult asyncResult)
		{
			try
			{
				// Result state is set to AsyncState.
				RequestState myRequestState = (RequestState)asyncResult.AsyncState;
				Stream responseStream = myRequestState.responseStream;
				int read = responseStream.EndRead(asyncResult);
				// Read the contents of the HTML page and then print to the console.
				if (read > 0)
				{
					myRequestState.requestData.Append(Encoding.UTF8.GetString(myRequestState.bufferRead, 0, read));
					IAsyncResult asynchronousResult = responseStream.BeginRead(myRequestState.bufferRead, 0, BUFFER_SIZE, new AsyncCallback(ReadCallBack), myRequestState);
				}
				else
				{
					responseStream.Close();
					allDone.Set();
				}
			}
			catch (WebException e)
			{
				Console.WriteLine(e.Message);
				allDone.Set();
			}

		}
	}
}
