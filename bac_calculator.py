#uses widmark formula, does not take into account eating and drinking
import os
ounce = 28.35
pound = 453.592
male = .68
female = .55
while True:
	os.system('clear')
	dict = {}
	grams_alcohol = 0; hours = 0
	sex = raw_input('Male (m); Female (f) ')
	if sex == 'm':
		gender = male
	if sex == 'f':
		gender = female
	pounds = raw_input('Enter weight in pounds. ')
	pounds_grams = float(float(pounds) * pound)
	while True:
		servings = 0
		os.system('clear')
		for x, y in dict.items():
			print x + ': ' + str(y) + ' ounces'
		if len(dict) > 0:
			print str(round(formula_total, 4))
			print '\n\n'
		var = raw_input('"Enter" for new drink; (a) add time elapsed; (d) when done. ')
		if var == 'd':
			break
		if var == 'a':
			if len(dict) < 1:
				continue
			var_hours = raw_input('How many hours since your last drink have elapsed? ')
			hours = float(var_hours) * .015
			formula_total = ((grams_alcohol / (pounds_grams * gender)) * 100) - hours
			continue
		drink = raw_input('Enter drink name ')
		drink_ounces = float(raw_input('Enter amount of ounces in serving. '))
		servings = float(raw_input('Enter number of servings. '))
		drink_ounces = drink_ounces * servings
		num_ounces = drink_ounces
		drink_percent = float(raw_input('Enter percentage alcohol in drink (as whole number). '))
		drink_ounces = drink_ounces * (drink_percent / 100)
		total_alcohol = drink_ounces * ounce
		grams_alcohol = total_alcohol + grams_alcohol
		dict[drink] = num_ounces
		formula_total = ((grams_alcohol / (pounds_grams * gender)) * 100) - hours


