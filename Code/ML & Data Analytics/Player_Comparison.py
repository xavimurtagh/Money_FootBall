import pandas as pd
from math import pi
import matplotlib.pyplot as plt
%matplotlib inline

#comparing player data points from my consolidated master dataset 
Pogba = {'Pace':85,'Shooting':92,'Passing':79,'Dribbling':95,'Defending':34,'Transfer Value':100}
Modric = {'Pace':80,'Shooting':90,'Passing':80,'Dribbling':80,'Defending':40,'Transfer Value':100}
data = pd.DataFrame([Pogba,Modric], index = ["Pogba","Modric"])
data

Attributes =list(data)
AttNo = len(Attributes)

values = data.iloc[1].tolist()
values += values [:1]
values

angles = [n / float(AttNo) * 2 * pi for n in range(AttNo)]
angles += angles [:1]

ax = plt.subplot(111, polar=True)
#adding the attribute labels to our axes 
plt.xticks(angles[:-1],Attributes)
#plotting the line around the outside of the filled area, using the angles and values calculated before 
ax.plot(angles,values)
#filling in the area plotted in the last line 
ax.fill(angles, values, 'teal', alpha=0.1)
#giving the plot a title and showing it 
ax.set_title("Pogba")
plt.show()

#finding the values and angles for Pogba - from the table at the top of the page 
values2 = data.iloc[0].tolist()
values2 += values2 [:1]
angles2 = [n / float(AttNo) * 2 * pi for n in range(AttNo)]
angles2 += angles2 [:1]
#creating the chart as before, but with both Pogba's and Modric angles/values 
ax = plt.subplot(111, polar=True)
plt.xticks(angles[:-1],Attributes)
ax.plot(angles,values)
ax.fill(angles, values, 'teal', alpha=0.1)
ax.plot(angles2,values2)
ax.fill(angles2, values2, 'red', alpha=0.1)
#individual text points are being added 
plt.figtext(0.2,0.9,"Pogba",color="red")
plt.figtext(0.2,0.85,"v")
plt.figtext(0.2,0.8,"Modric",color="teal")
plt.show()
