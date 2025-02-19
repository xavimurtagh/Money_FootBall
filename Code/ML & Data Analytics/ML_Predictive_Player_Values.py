# Predictive player values using training weights
import os
import scipy as sp
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score

os.chdir('c:\cs project\code')
import Data_Analytics as DataViz

os.chdir('c:\cs project\code')
import Goalkeepers as GK

os.chdir('c:\cs project\code')
import Midfielders as MID

os.chdir('c:\cs project\code')
import Forwards as FWD

#data gathering of players and seasons
data=pd.DataFrame.append(GK.dataGK,[MID.dataMID,FWD.dataFWD])
dataseason1920=data[data['Season_201920#']==1]
dataseason1819=data[data['Season_201819#']==1]
dataseason1718=data[data['Season_201718#']==1]

#applying training weights
w1920=1
w1819=0.8
w1718=0.7

#creating predsOLS value which is the predictive value of player for each season
dataseason1920['weights']=w1920
dataseason1920['predsOLS']=w1920*dataseason1920['predsOLS']
dataseason1819['weights']=w1819
dataseason1819['predsOLS']=w1819*dataseason1819['predsOLS']
dataseason1718['weights']=w1718
dataseason1718['predsOLS']=w1718*dataseason1718['predsOLS']
datafinal=pd.DataFrame.append(dataseason1920,[dataseason1819,dataseason1718])
