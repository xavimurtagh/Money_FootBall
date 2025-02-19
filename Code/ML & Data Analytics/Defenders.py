# %%
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
from statsmodels.regression.linear_model import OLS
from statsmodels.stats.outliers_influence import OLSInfluence
from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score
from sklearn.base import BaseEstimator, RegressorMixin
%matplotlib inline

# %%
os.chdir('c:\cs project\data')
data = pd.read_csv('consolidated_data_2021.csv',sep=';',engine='python')
data05 =  pd.read_csv('consolidated_data_2019.csv',sep=';',engine='python')
data1 = pd.read_csv('consolidated_data_2020.csv',sep=';',engine='python')
data1=pd.DataFrame.append(data,data1)
data1=pd.DataFrame.append(data1,data05,ignore_index=True)
data1.sort_values('player')

# %%
#adding variables to dataset
data1 = pd.get_dummies(data1, columns=['league'])
data1 = data1.rename({"league_Bundesliga":"isBundesliga",
                                "league_La Liga":"isLaLiga",
                                "league_Premier League":"isPremierLeague",
                                "league_Ligue 1":"isLigue1",
                                "league_Serie A":"isSerieA"},axis='columns')
data1=pd.get_dummies(data1,columns=['Season'])
data1=pd.get_dummies(data1,columns=['foot'])
#deleting potential outliers that actually contribute nothing
data1=data1[data1['value']>1000000]
data1=data1[data1['games']>5]
data1=data1[data1['age']>0]
data1=data1[data1['height']>0]
data1

# %%
#DEFENDERS
dataDEF = data1[data1['position2'].str[:8]=='Defender']
dataDEF

# %%
# log notation 
def ln(x):
    return np.log(x)

dataDEF['pctpassesshort']=(dataDEF['passes_short']/dataDEF['passes'])/dataDEF['minutes']
dataDEF['pctpassesmedium']=(dataDEF['passes_medium']/dataDEF['passes'])/dataDEF['minutes']
dataDEF['pctpasseslong']=(dataDEF['passes_long']/dataDEF['passes'])/dataDEF['minutes']
dataDEF['pctpassescompleted']=dataDEF['passes_completed']/dataDEF['passes']/dataDEF['minutes']
#Creating a linear regression
trainDEF, testDEF = train_test_split(dataDEF, train_size=0.8)
modelDEF=smf.ols('ln(value)~age+CL+goals+xg_xa_per90+'
                  'passes_ground+touches_att_pen_area+touches_def_pen_area+aerials_won_pct'
                   '+'
                   ''
                   '+isPremierLeague+isLigue1'
                   '+Pts+xGA+xG',data=dataDEF)
modelDEF1=smf.ols('value~wins_gk+clean_sheets+Pts+W+GDiff+clean_sheets_pct+CL+xGDiff+GF+xG+passes_ground+passes_completed_medium+passes_medium+games+games_starts+minutes_90s+minutes+games_gk+games_starts_gk+minutes_90s_gk+minutes_gk+passes_throws_gk+passes_other_body+passes_completed+passes_received+passes_live+pass_targets+carries+touches_live_ball+passes_pct_long+touches_def_pen_area+passes_completed_short+passes_gk+passes_pressure+passes_pct+def_actions_outside_pen_area_gk+passes_total_distance+psxg_net_gk+touches_def_3rd+passes_short+passes+touches+ball_recoveries+through_balls+dribble_tackles_pct+psxg_net_per90_gk+passes_pct_launched_gk+save_pct+passes_low+xa_net+passes_progressive_distance+WinCL+carry_distance+gca_passes_dead+errors+passes_switches+passes_completed_long+crosses_gk+passes_intercepted+crosses_stopped_gk+dribbles_completed_pct+passes_left_foot+carry_progressive_distance+isPremierLeague+MP+avg_distance_def_actions_gk+saves+draws_gk+assists+goal_kicks+gca+foot_left+isLaLiga+passes_right_foot+shots_on_target_against+passes_pct_short+aerials_won_pct+passes_dead+assists_per90+gca_per90+passes_completed_launched_gk+passes_long+sca_passes_dead+def_actions_outside_pen_area_per90_gk+passes_pct_medium+crosses_stopped_pct_gk+passes_oob+own_goals_against_gk+gca_passes_live+pens_conceded+shots_on_target_pct+throw_ins+psxg_gk+pens_missed_gk+goals_assists_pens_per90+passes_received_pct+height+pens_allowed+goals_assists_per90+passes_launched_gk+npxg_net+pens_att_gk+cards_red+sca+xg_net+sca_passes_live+passes_high+fouled+free_kick_goals_against_gk+cards_yellow+corner_kicks_in+xa+passes_offsides+pens_saved+dribbles_completed+dribble_tackles+assisted_shots+players_dribbled_past+npxg_per_shot+xa_per90+passes_into_penalty_area+pressure_regain_pct+tackles_def_3rd+passes_free_kicks+miscontrols+dribbles+dribbles_vs+passes_head+isSerieA+clearances+corner_kick_goals_against_gk+dribbled_past+corner_kicks+shots_on_target_per90+tackles+goals_against_gk+pressures_def_3rd+tackles_won+dispossessed+tackles_mid_3rd+fouls+shots_total_per90+progressive_passes+offsides+npxg_xa_per90+xg_xa_per90+goals_pens_per90+passes_blocked+touches_mid_3rd+aerials_won+shots_on_target+sca_dribbles+gca_shots+pens_att+pens_made+pens_won+nutmegs+goals_per90+crosses+pressures+blocked_shots+pressure_regains+interceptions+goals_per_shot+shots_total+pressures_mid_3rd+shots_free_kicks+touches_att_pen_area+goals+sca_fouled+pressures_att_3rd+aerials_lost+touches_att_3rd+tackles_att_3rd+xg+goals_per_shot_on_target+own_goals+npxg+sca_shots+npxg_per90+xg_per90+blocks+blocked_passes+sca_per90+crosses_into_penalty_area+passes_into_final_third+D+psnpxg_per_shot_on_target_against+goal_kick_length_avg+foot_right+isBundesliga+isLigue1+passes_length_avg_gk+pct_goal_kicks_launched+losses_gk+pct_passes_launched_gk+age+goals_against_per90_gk+xGA+GA+L+LgRk+gca_dribbles+gca_fouled+gca_og_for+corner_kicks_out+corner_kicks_straight+foot_both+cards_yellow_red+blocked_shots_saves',data=dataDEF)    

#progressive_passesm
resultsDEF=modelDEF.fit()
resultsDEF_params=resultsDEF.params
resultsDEF1=modelDEF1.fit()
resultsDEF1_params=resultsDEF1.params
#Creating a robust regression
modelDEFrobust=sm.RLM(modelDEF.endog,modelDEF.exog,data=trainDEF).fit()

finalDEF1 = sm.regression.linear_model.OLSResults(modelDEF, 
                                              modelDEFrobust.params, 
                                              modelDEF.normalized_cov_params)
#print(resultsDEF.get_robustcov_results(cov_type='HC1').summary())
finalDEF1.summary()
#ball recoveries, dribbled past, passes head - to describe

# %%
predictionsDEF=finalDEF1.predict(dataDEF)
dataDEF['predsOLS']=np.exp(predictionsDEF)



