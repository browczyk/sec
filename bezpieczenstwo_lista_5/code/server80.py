import sys
from http.server import HTTPServer, BaseHTTPRequestHandler


class Redirect(BaseHTTPRequestHandler):
   def do_GET(self):
       self.send_response(302)
       self.send_header('Location', 'https://smail.pwr.edu.pl')
       self.end_headers()

print("redirecting on port 80")
httpd = HTTPServer(("", 80), Redirect)
httpd.serve_forever()
