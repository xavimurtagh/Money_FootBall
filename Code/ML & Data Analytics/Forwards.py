import os
import statistics
import scipy as sp
import math
import pandas as pd
import numpy as np
import matplotlib as mpl
import matplotlib.pyplot as plt
import matplotlib.ticker as tick
import seaborn as sns
import statsmodels.api as sm
import statsmodels.formula.api as smf
from statsmodels.stats.outliers_influence import variance_inflation_factor
from statsmodels.tools.tools import add_constant
from statsmodels.regression.linear_model import OLS
from statsmodels.stats.outliers_influence import OLSInfluence
from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score
from sklearn.base import BaseEstimator, RegressorMixin

#importing data 
os.chdir('c:\cs project\data')
data = pd.read_csv('consolidated_data_2021.csv',sep=';',engine='python')
data05 =  pd.read_csv('consolidated_data_2019.csv',sep=';',engine='python')
data1 = pd.read_csv('consolidated_data_2020.csv',sep=';',engine='python')
data1=pd.DataFrame.append(data,data1)
data1=pd.DataFrame.append(data1,data05,ignore_index=True)
data1.sort_values('player')

#adding dummy variables to dataset and cleaning data names and variables to dataset 
data1 = pd.get_dummies(data1, columns=['league'])
data1 = data1.rename({"league_Bundesliga":"isBundesliga",
                                "league_La Liga":"isLaLiga",
                                "league_Premier League":"isPremierLeague",
                                "league_Ligue 1":"isLigue1",
                                "league_Serie A":"isSerieA"},axis='columns')
data1=pd.get_dummies(data1,columns=['Season'])
data1=pd.get_dummies(data1,columns=['foot'])

#deleting potential outliers 
data1=data1[data1['value']>1000000]
data1=data1[data1['games']>5]
data1=data1[data1['age']>0]
data1=data1[data1['height']>0]
data1

#FORWARDS
dataFWD = data1[data1['position2'].str[:7]=='Forward']
dataFWD2 = data1[data1['position2'].str[:6]=='attack']
dataFWD=pd.DataFrame.append(dataFWD,dataFWD2)
dataFWD

#log returns 
def ln(x):
    return np.log(x)

#creating a training set on forward attributes by splitting into test & training set of 0.8  
trainFWD, testFWD = train_test_split(dataFWD, train_size=0.8)
modelFWD1=smf.ols('ln(value)~wins_gk+clean_sheets+Pts+W+GDiff+clean_sheets_pct+CL+xGDiff+GF+xG+passes_ground+passes_completed_medium+passes_medium+games+games_starts+minutes_90s+minutes+games_gk+games_starts_gk+minutes_90s_gk+minutes_gk+passes_throws_gk+passes_other_body+passes_completed+passes_received+passes_live+pass_targets+carries+touches_live_ball+passes_pct_long+touches_def_pen_area+passes_completed_short+passes_gk+passes_pressure+passes_pct+def_actions_outside_pen_area_gk+passes_total_distance+psxg_net_gk+touches_def_3rd+passes_short+passes+touches+ball_recoveries+through_balls+dribble_tackles_pct+psxg_net_per90_gk+passes_pct_launched_gk+save_pct+passes_low+xa_net+passes_progressive_distance+WinCL+carry_distance+gca_passes_dead+errors+passes_switches+passes_completed_long+crosses_gk+passes_intercepted+crosses_stopped_gk+dribbles_completed_pct+passes_left_foot+carry_progressive_distance+isPremierLeague+MP+avg_distance_def_actions_gk+saves+draws_gk+assists+goal_kicks+gca+foot_left+isLaLiga+passes_right_foot+shots_on_target_against+passes_pct_short+aerials_won_pct+passes_dead+assists_per90+gca_per90+passes_completed_launched_gk+passes_long+sca_passes_dead+def_actions_outside_pen_area_per90_gk+passes_pct_medium+crosses_stopped_pct_gk+passes_oob+own_goals_against_gk+gca_passes_live+pens_conceded+shots_on_target_pct+throw_ins+psxg_gk+pens_missed_gk+goals_assists_pens_per90+passes_received_pct+height+pens_allowed+goals_assists_per90+passes_launched_gk+npxg_net+pens_att_gk+cards_red+sca+xg_net+sca_passes_live+passes_high+fouled+free_kick_goals_against_gk+cards_yellow+corner_kicks_in+xa+passes_offsides+pens_saved+dribbles_completed+dribble_tackles+assisted_shots+players_dribbled_past+npxg_per_shot+xa_per90+passes_into_penalty_area+pressure_regain_pct+tackles_def_3rd+passes_free_kicks+miscontrols+dribbles+dribbles_vs+passes_head+isSerieA+clearances+corner_kick_goals_against_gk+dribbled_past+corner_kicks+shots_on_target_per90+tackles+goals_against_gk+pressures_def_3rd+tackles_won+dispossessed+tackles_mid_3rd+fouls+shots_total_per90+progressive_passes+offsides+npxg_xa_per90+xg_xa_per90+goals_pens_per90+passes_blocked+touches_mid_3rd+aerials_won+shots_on_target+sca_dribbles+gca_shots+pens_att+pens_made+pens_won+nutmegs+goals_per90+crosses+pressures+blocked_shots+pressure_regains+interceptions+goals_per_shot+shots_total+pressures_mid_3rd+shots_free_kicks+touches_att_pen_area+goals+sca_fouled+pressures_att_3rd+aerials_lost+touches_att_3rd+tackles_att_3rd+xg+goals_per_shot_on_target+own_goals+npxg+sca_shots+npxg_per90+xg_per90+blocks+blocked_passes+sca_per90+crosses_into_penalty_area+passes_into_final_third+D+psnpxg_per_shot_on_target_against+goal_kick_length_avg+foot_right+isBundesliga+isLigue1+passes_length_avg_gk+pct_goal_kicks_launched+losses_gk+pct_passes_launched_gk+age+goals_against_per90_gk+xGA+GA+L+LgRk+gca_dribbles+gca_fouled+gca_og_for+corner_kicks_out+corner_kicks_straight+foot_both+cards_yellow_red+blocked_shots_saves',data=dataFWD)    

#fitting a linear model and minimizing the residual sum of squares between the targets in the dataset, and the targets predicted. 
modelFWD=smf.ols('ln(value)~age+CL+goals+gca'
                   '+Pts+xG+xGA+dribbles_completed'
                   ''
                   '+xg_xa_per90+touches_att_pen_area+'
                   '+passes_into_final_third+'
                   '+isPremierLeague+isLigue1',data=dataFWD)
#modelFWD=smf.ols('ln(value)~Pts+touches_att_pen_area',data=dataFWD)
resultsFWD=modelFWD.fit()
resultsFWD_params=resultsFWD.params
resultsFWD1=modelFWD1.fit()
resultsFWD1_params=resultsFWD1.params

#creating a robust regression
modelFWDrobust=sm.RLM(modelFWD.endog,modelFWD.exog,data=trainFWD).fit()
finalFWD1 = sm.regression.linear_model.OLSResults(modelFWD, 
                                              modelFWDrobust.params, 
                                              modelFWD.normalized_cov_params)
finalFWD1.summary()

#getting data for various statistics for seasons and sorting by value 
data=dataFWD[dataFWD['Season_201920#']==1]
data=data[['player','value','goals','xg_xa_per90','passes_into_final_third','touches_att_pen_area','gca','dribbles_completed']]
data1=data.sort_values('value',ascending=False)[0:10]
data1

#using log function to plot values 
def millions(x, pos):
    'The two args are the value and tick position'
    return '%1.1fM' % (x * 1e-6)
formatter = mpl.ticker.FuncFormatter(millions)

#removing outliers 
dataFWD=dataFWD[dataFWD['xg_xa_per90']>0]
dataFWD=dataFWD[dataFWD['passes_into_final_third']>0]
dataFWD=dataFWD[dataFWD['touches_att_pen_area']>0]
dataFWD=dataFWD[dataFWD['gca']>0]
dataFWD=dataFWD[dataFWD['dribbles_completed']>0]

#finding the product moment correlation coefficients 
goals=np.corrcoef(dataFWD['value'],dataFWD['goals'])
xg_xa_per90=np.corrcoef(dataFWD['value'],dataFWD['xg_xa_per90'])
passes_into_final_third=np.corrcoef(dataFWD['value'],dataFWD['passes_into_final_third'])
touches_pen_area=np.corrcoef(dataFWD['value'],dataFWD['touches_att_pen_area'])
gca=np.corrcoef(dataFWD['value'],dataFWD['gca'])
dribbles_completed=np.corrcoef(dataFWD['value'],dataFWD['dribbles_completed'])
goals=goals[0,1]
xg_xa_per90=xg_xa_per90[0,1]
passes_into_final_third=passes_into_final_third[0,1]
touches_pen_area=touches_pen_area[0,1]
gca=gca[0,1]
dribbles_completed=dribbles_completed[0,1]

#setting up the data analytics graphs
fig, ax = plt.subplots(3, 2, figsize=(12, 12))
sns.regplot(ax=ax[0,0],x=dataFWD['goals'],y=dataFWD['value'],data=dataFWD,color='g')
sns.regplot(ax=ax[1,0],x=dataFWD['xg_xa_per90'],y=dataFWD['value'],data=dataFWD,color='blue')
sns.regplot(ax=ax[2,0],x=dataFWD['passes_into_final_third'],y=dataFWD['value'],data=dataFWD,color='orange')
sns.regplot(ax=ax[0,1],x=dataFWD['touches_att_pen_area'],y=dataFWD['value'],data=dataFWD,color='cyan')
sns.regplot(ax=ax[1,1],x=dataFWD['gca'],y=dataFWD['value'],data=dataFWD,color='magenta')
sns.regplot(ax=ax[2,1],x=dataFWD['dribbles_completed'],y=dataFWD['value'],data=dataFWD,color='chocolate')

#the product moment correlation coefficient put for each statistic on the graph
ax[0,0].yaxis.set_major_formatter(formatter)
ax[0,0].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[0,0].annotate("{:.2f}".format(goals),xy=(0.85,0.85), xycoords="axes fraction")

ax[1,0].yaxis.set_major_formatter(formatter)
ax[1,0].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[1,0].annotate("{:.2f}".format(xg_xa_per90),xy=(0.85,0.85), xycoords="axes fraction")

ax[2,0].yaxis.set_major_formatter(formatter)
ax[2,0].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[2,0].annotate("{:.2f}".format(passes_into_final_third),xy=(0.85,0.85), xycoords="axes fraction")

ax[0,1].yaxis.set_major_formatter(formatter)
ax[0,1].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[0,1].annotate("{:.2f}".format(touches_pen_area),xy=(0.85,0.85), xycoords="axes fraction")

ax[1,1].yaxis.set_major_formatter(formatter)
ax[1,1].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[1,1].annotate("{:.2f}".format(gca),xy=(0.85,0.85), xycoords="axes fraction")

ax[2,1].yaxis.set_major_formatter(formatter)
ax[2,1].annotate("r=",xy=(0.8,0.85), xycoords="axes fraction")
ax[2,1].annotate("{:.2f}".format(dribbles_completed),xy=(0.85,0.85), xycoords="axes fraction")


