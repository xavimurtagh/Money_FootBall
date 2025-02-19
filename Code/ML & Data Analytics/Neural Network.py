#import sklearn neural network
import os
import pandas as pd
import numpy as np
import sklearn as SKLearn
from sklearn.neural_network import MLPClassifier
from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score


os.chdir('c:\CS Project\Code')

#importing my goalkeeper code 
import Goalkeepers as GK


data=GK.dataGK
data

#defining overvalued as difference between value and predicted value
data['Over/undervalued']=np.where(data['value']-data['predsOLS']>0, 'Overvalued', 'Undervalued')
data


#splitting data and creating training set for goalkeeper data 
yGK = data['Over/undervalued']
XGK = data[['age','psxg_gk','games_starts','passes_pct_launched_gk','pct_goal_kicks_launched','isPremierLeague','isLaLiga','isLigue1','clean_sheets','saves']]
XGK_train, XGK_test, yGK_train, yGK_test = train_test_split(XGK,yGK,test_size=0.2)

#applying MLPC neural network  
net=MLPClassifier(hidden_layer_sizes=(100,),activation='logistic')
#applying netsolver ibfgs algorithm 
netsolver='lbfgs'
net.max_iter=1000

#apply XGK fit and test prediction 
net.fit(XGK_test,yGK_test)
ytest_predict=net.predict(XGK)
trueorfalse=np.where(np.array(yGK)==ytest_predict,'T','F')

#output is the % value of true vs false 
outcome=len(trueorfalse[trueorfalse=='T'])/len(trueorfalse)*100
outcome=format(outcome, '.2f')
outcome=str(outcome)
print('There are ' + outcome + '%' + ' correct classificiations')


