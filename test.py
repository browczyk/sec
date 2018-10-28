import sys
from selenium import webdriver

file_name = sys.argv[1]

driver = webdriver.Firefox()
driver.get("http://www.mikolaj.ovh")
driver.delete_all_cookies()

with open(file_name, "r") as cookie_file:
    for lines in cookie_file:
        line = lines.rstrip('\n')
        driver.add_cookie({'name':line.split('=')[0], 'value':line.split('=')[1], 'path':'/'})


for cookie in driver.get_cookies():
    print ((cookie['name'], cookie['value']))
