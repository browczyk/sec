from http.server import HTTPServer, BaseHTTPRequestHandler
import ssl
import cgi

with open('/home/pioter/sec/index1.txt', 'r') as file:
    index = file.read()


class SimpleHTTPRequestHandler(BaseHTTPRequestHandler):

    def do_GET(self):
        if self.path.endswith(".gif"):
            print(self.path)
            f=open('/home/pioter/sec'+ self.path, 'rb')
            self.send_response(200)
            self.send_header('Content-type','image/png')
            self.end_headers()
            self.wfile.write(f.read())
            f.close()
            return
        self.send_response(200)
        self.send_header('Content-type','text/html')
        self.end_headers()
        self.wfile.write(bytes(index, "utf-8"))


    def do_POST(self):
        self.send_response(200)
        self.send_header('Content-type','text/html')
        self.end_headers()
        form  = cgi.FieldStorage(fp=self.rfile,
		headers=self.headers,
		environ={'REQUEST_METHOD': 'POST'}
        )
        print(form.getvalue("username")," ",form.getvalue("password"))
        self.wfile.write(bytes("<html><body><h1>Username and password saved!</h1></body></html>","utf-8"))


httpd = HTTPServer(('',443),SimpleHTTPRequestHandler)

httpd.socket = ssl.wrap_socket(httpd.socket,
	keyfile = "/home/pioter/sec/keys/privkeyA.pem",
	certfile = '/home/pioter/sec/keys/certA.crt', 
	server_side = True)

httpd.serve_forever()
