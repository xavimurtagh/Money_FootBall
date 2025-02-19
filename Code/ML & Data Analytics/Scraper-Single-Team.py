#single team
import requests
from bs4 import BeautifulSoup
import pandas as pd

#headers routine is required so that the website knows I’m a real user and not a bot 
headers = {'User-Agent': 
           'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36'}

#page I’m are trying to scrape data from 
page = "https://www.transfermarkt.co.uk/manchester-united/startseite/verein/985"
pageTree = requests.get(page, headers=headers)
pageSoup = BeautifulSoup(pageTree.content, 'html.parser')

#finding exact match for span and td which represents player and value 
Players = pageSoup.find_all("span", {"class": "show-for-small"})
Values = pageSoup.find_all("td", {"class": "rechts hauptlink"})
PlayersList = []
ValuesList = []

length = len(Players)

for i in range(0,length):
    PlayersList.append(Players[i].text)
    ValuesList.append(Values[i].text)
    
df = pd.DataFrame({"Players":PlayersList[0:30],"Values":ValuesList})

df


