#2-2-18
import os, sys, datetime, time, os.path
from subprocess import call
day = datetime.date.today().strftime("%A")
day_of_month = datetime.date.today().strftime("%d")
month = datetime.date.today().strftime("%B")
workout_file = '/home/jonathan/Documents/python_text_files/health_program/workouts.txt'
foods_file = '/home/jonathan/Documents/python_text_files/health_program/days/'+ month[0:3] + '' + day_of_month + '' + day + '.txt'
food_file = open('/home/jonathan/Documents/python_text_files/health_program/possible_foods.txt', 'r').read().split('\n')
foods_list = []
foods = {}
cups_water = 0
veggies = 0
fruits = 0
vitamin = 'no'
bicep_workout = '6 sets.\n10 reps per set.\nFirst and last set are with lighter dumbell.\n60 reps in total for each arm.'
shoulder_workout = '6 sets.\n10 reps per set.\nFirst and last set are with lighter dumbell.\n60 reps in total for each arm.'
core_workout = '20 crunches.\n20 seconds bicycle.\nRepeat two more sets.\nEnd with planking for as long as possible.'
chest_workout = '6 sets.\n10 reps per set.\nAlternate between regular and knee pushups.\n60 reps in total.'

def load():
	global foods_file
	if os.path.exists(foods_file) == True:
		var = raw_input('Restore today\'s session? (y/n) ')
		if var != 'n':
			restore()
		if var == 'n':
			var2 = raw_input('Are you sure? You will lose the previous session? (y/n) ')
			if var2 != 'y':
				restore()

def settings_food_list_add():
	os.system('clear')
	settings_food_list = []
	while True:
		calories = ''
		sodium = ''
		food = raw_input('Enter the food ')
		if food == '':
			return
		food = food.replace(' ', '_')
		while not calories.isdigit():
			calories = raw_input('Enter the calories ')
		while not sodium.isdigit():
			sodium = raw_input('Enter the sodium ')
		add_to_foods_list(food, calories, sodium)
		settings_food_list.append(food)
		os.system('clear')
		print 'Foods added:'
		for x in settings_food_list:
			print x
		print ''
		

def check_dict(item):
	global calories, sodium
	for x,y in foods.items():
		if item == x:
			calories = int(calories) + y[0]
			sodium = int(sodium) + y[1]

def add_saved_foods():
	global calories, sodium
	while True:
		os.system('clear')
		for item in foods_list:
			num = foods_list.index(item)
			print str(num) + ' ' + item[0] + ': ' + str(item[1]) + ' calories'
		var = raw_input('\nEnter the food. ')
		if var == '':
			return
		food_to_add = foods_list[int(var)]
		calories = int(food_to_add[1])
		sodium = int(food_to_add[2])
		check_dict(food_to_add[0])
		foods[food_to_add[0]] = [int(calories), int(sodium)]
		
		

def possible_foods(food_file):
	for x in food_file:
		if x == '':
			del x
			continue
		x = x.strip()
		list = x.split()
		foods_list.append(list)

def add_to_foods_list(food, calories, sodium):
	temp_list = [str(food), str(calories), str(sodium)]
	foods_list.append(temp_list)

def save_foods_list():
	file = open('/home/jonathan/Documents/python_text_files/health_program/possible_foods.txt', 'w')
	for x in foods_list:
		file.write(x[0] + ' ' + str(x[1]) + ' ' + str(x[2]) + '\n')
	file.close()
			

def all_workouts():
	os.system('clear')
	print 'Shoulder and Triceps:\n' + shoulder_workout + '\n\n'
	print 'Core:\n' + core_workout + '\n\n'
	print 'Chest:\n' + chest_workout + '\n\n'
	print 'Biceps:\n' + bicep_workout + '\n\n'
	var = raw_input('Press "Enter" to return')

def save_workouts():
	global workout_file
	file = open(workout_file, 'w')
	file.write('biceps ' + str(biceps) + '\n')
	file.write('shoulders ' + str(shoulders) + '\n')
	file.write('chest ' + str(chest) + '\n')
	file.write('core ' + str(core))
	file.close()

def check_workout(day):
	global biceps, shoulders, core, chest, workout_file
	if day == 'Sunday':
		var = raw_input('It\'s Sunday. Reset workout totals? (y/n) ')
		if var == 'y':
			biceps = 0
			shoulders = 0
			chest = 0
			core = 0
			save_workouts()
			return
	file = open(workout_file, 'r').read().split('\n')
	for x in file:
		if x == '':
			del x
			continue
		x = x.split()
		if x[0] == 'biceps':
			biceps = int(x[1])
		if x[0] == 'chest':
			chest = int(x[1])
		if x[0] == 'core':
			core = int(x[1])
		if x[0] == 'shoulders':
			shoulders = int(x[1])

def workout_totals():
	if biceps == 0:
		print 'You have yet to do your bicep workout this week.'
	if biceps == 1:
		print 'You have completed your weekly biceps workout!'
	if chest == 0:
		print 'You have two more chest workouts this week.'
	if chest == 1:
		print 'You have one more chest workout this week.'
	if chest == 2:
		print 'You have completed your weekly chest workouts!'
	if core == 0:
		print 'You have two more core workouts this week.'
	if core == 1:
		print 'You have one more core workout this week.'
	if core == 2:
		print 'You have completed your weekly core workouts!'
	if shoulders == 0:
		print 'You have two more shoulder and tricep workouts this week.'
	if shoulders == 1:
		print 'You have one more shoulder and tricep workout this week.'
	if shoulders == 2:
		print 'You have completed your shoulder and tricep workouts this week!'

def print_workout_info(day):
	if day == 'Tuesday' or day == 'Wednesday':
		if shoulders == 0:
			print 'You missed your shoulder and triceps workout.'
		if core == 0:
			print 'You missed your core workout'
	if day == 'Thursday' or day == 'Friday':
		if shoulders == 0:
			print 'You missed your shoulder and triceps workout.'
		if core == 0:
			print 'You misssed both of your core workouts.'
		if core == 1:
			print 'You missed one of your core workouts.'
		if biceps == 0:
			print 'You missed your biceps workout.'
		if chest == 0:
			print 'You missed your chest workout.'
	if day == 'Saturday':
		if shoulders == 0:
			print 'You missed both of your shoulder and tricep workouts.'
		if shoulders == 1:
			print 'You missed one of your shoulder and tricep workouts.'
		if chest == 0:
			print 'You missed both of your chest workouts.'
		if chest == 1:
			print 'You missed one of your chest workouts.'
		if core == 0:
			print 'You missed both of your core workouts.'
		if core == 1:
			print 'You missed one of your core workouts.'
		if biceps == 0:
			print 'You missed your bicep workout.'
	if day == 'Sunday':
		print 'It\'s a new week! Make it count!'
			
		
def workouts(day):
	global bicep_workout, shoulder_workout, core_workout, chest_workout
	global biceps, shoulders, core, chest
	while True:
		os.system('clear')
		if day == 'Monday':
			print 'Shoulder and Triceps:\n' + shoulder_workout + '\n\n'
			print 'Core:\n' + core_workout + '\n\n'
		elif day == 'Wednesday':
			print 'Biceps:\n' + bicep_workout + '\n\n'
			print 'Core:\n' + core_workout + '\n\n'
			print 'Chest:\n' + chest_workout + '\n\n'
		elif day == 'Friday':
			print 'Shoulder and Triceps:\n' + shoulder_workout + '\n\n'
			print 'Chest:\n' + chest_workout + '\n\n'
		else:
			print 'No workout scheduled!\n\n'
		workout_totals()
		var = raw_input('\n\nPress "Enter" to return; (a) for all workouts; (c) to mark a workout done. ')
		if var == '':
			return
		if var == 'a':
			all_workouts()
		if var == 'c':
			var = raw_input('(a) biceps; (b) core; (c) chest; (d) shoulders and triceps. ')
			if var == 'a':
				biceps = biceps + 1
			if var == 'b':
				core = core + 1
			if var == 'c':
				chest = chest + 1
			if var == 'd':
				shoulders = shoulders + 1
	
def workout(day):
	if day == 'Wednesday':
		print 'Today is Bicep, Core, and Chest workout! Do it to get stronger and better looking!'
	if day == 'Friday':
		print 'Today is Shoulder, Tricep, and Chest workout! Do it to get stronger and better looking!'
	if day == 'Monday':
		print 'Today is Shoulder, Tricep, and Core workout! Do it to get stronger and better looking!'


def print_totals():
	global cups_water, veggies, fruits
	os.system('clear')
	calories_total = 0
	sodium_total = 0
	for x,y in foods.items():
		print x + '\n---------------'
		print 'Calories: ' + str(y[0])
		print 'Sodium: ' + str(y[1]) + '\n\n'
		sodium_total = sodium_total + y[1]
		calories_total = calories_total + y[0]
	print '\n\nCalories total: ' + str(calories_total)
	print 'Sodium total: ' + str(sodium_total)
	print 'Water total: ' + str(cups_water)
	print 'Veggies total: ' + str(veggies)
	print 'Fruits total: ' + str(fruits)
	var = raw_input('\n\n\nPress "Enter" when done!')

def save():
	global cups_water, veggies, fruits, vitamin, foods_file
	file = open(foods_file, 'w')
	for x,y in foods.items():
		file.write(x + ' ' + str(y[0]) + ' ' + str(y[1]) + '\n')
	file.write('cups ' + str(cups_water) + '\n')
	file.write('veggies ' + str(veggies) + '\n')
	file.write('fruits ' + str(fruits) + '\n')
	file.write('vitamin ' + str(vitamin))
	file.close()

def restore():
	global cups_water, veggies, fruits, vitamin, foods_file
	file = open(foods_file, 'r').readlines()
	for x in file:
		list = x.split()
		if 'cups' not in list and 'veggies' not in list and 'fruits' not in list and 'vitamin' not in list:
			list[2] = list[2].replace('\n', '')
			foods[list[0]] = [int(list[1]), int(list[2])]
		if 'cups' in list or 'veggies' in list or 'fruits' in list or 'vitamin' in list:
			list[1] = list[1].replace('\n', '')
			if list[0] == 'cups':
				cups_water = int(list[1])
			if list[0] == 'veggies':
				veggies = int(list[1])
			if list[0] == 'fruits':
				fruits = int(list[1])
			if list[0] == 'vitamin':
				vitamin = list[1]

def day_to_restore():
	global foods_file
	var = ''
	os.system('clear')
	day_list = os.listdir('/home/jonathan/Documents/python_text_files/health_program/days')
	for x in day_list:
		num = day_list.index(x)
		print str(num) + ': ' + x
	while not var.isdigit():
		var = raw_input('\nEnter the day to restore. ')
	if int(var) > -1 and int(var) <= len(day_list):
		folder = '/home/jonathan/Documents/python_text_files/health_program/days/' + str(day_list[int(var)])
		foods_file = folder
	else:
		decision = 'back'
		return decision


def check(cups_water, veggies, fruits):
	calories_total = 0
	sodium_total = 0
	for x,y in foods.items():
		sodium_total = sodium_total + y[1]
		calories_total = calories_total + y[0]
	if calories_total >= 1850:
		print 'You are ' + str(calories_total - 1850) + ' over your allowed calories!! Careful Fatty!!'
	else:
		print 'You are allowed ' + str(1850 - calories_total) + ' more calories.'
	if sodium_total >= 2000:
		print 'You are ' + str(sodium_total - 2000) + 'mg over your allowed sodium!! Protect your kidney\'s!!'
	else:
		print 'You are allowed ' + str(2000 - sodium_total) + 'mg more sodium.'
	print '\n'
	if cups_water >= 8:
		print 'You have drunk ' + str(cups_water) + ' cups of water and met your goal!!'
	else:
		print 'You need ' + str(8 - cups_water) + ' more cups of water.'
	if veggies >= 4:
		print 'You have had ' + str(veggies) + ' servings of vegetables today and met your goal!!'
	else:
		print 'You need ' + str(4 - veggies) + ' more servings of vegetables.'
	if fruits >= 3:
		print 'You have had ' + str(fruits) + ' servings of fruits today and met your goal!!'
	else:
		print 'You need ' + str(3 - fruits) + ' more servings of fruits.'
	print '\n'

def settings():
	global cups_water, veggies, fruits
	while True:
		num = ''
		cals = 0
		veggie = ''
		water = ''
		fruit = ''
		os.system('clear')
		var1 = raw_input('(a) to change totals; (f) add to saved food list ')
		if var1 == 'f':
			settings_food_list_add()
		if var1 == 'a':
			while True:
				os.system('clear')
				var = raw_input('(a) change veggie total; (b) change fruits total; (c) change water total; (d) change calorie totals ')
				if var == 'a':
					while not veggie.isdigit():
						veggie = raw_input('Enter new veggie total. ')
					veggies = veggie
				if var == 'b':
					while not fruit.isdigit():
						fruit = raw_input('Enter new fruit total. ')
					fruits = fruit
				if var == 'c':
					while not water.isdigit():
						water = raw_input('Enter new water total. ')
					cups_water = water
				if var == 'd':
					var2 = raw_input('(a) add calories; (b) subtract calories ')
					if var2 == 'a':
						while not num.isdigit():
							num = raw_input('Enter amount of calories to add. ')
						for x, y in foods.items():
							if x == 'raw_calories':
								cals = int(y[0])
						num = cals + int(num)
						foods['raw_calories'] = [int(num), 0]
					if var2 == 'b':
						while not num.isdigit():
							num = raw_input('Enter amount of calories to subtract. ')
						for x, y in foods.items():
							if x == 'raw_calories':
								cals = int(y[0])
						num = cals - int(num)
						foods['raw_calories'] = [int(num), 0]
				if var == '':
					break
		if var1 == '':
			return
						
possible_foods(food_file)
load()	
check_workout(day)
while True:
	calories = ''
	sodium = ''
	water = ''
	calories_total = 0
	sodium_total = 0
	os.system('clear')
	for x,y in foods.items():
		sodium_total = sodium_total + y[1]
		calories_total = calories_total + y[0]
	print 'Calories total: ' + str(calories_total) + '  ',
	print 'Sodium total: ' + str(sodium_total) + '   Water total: ' + str(cups_water) + '   Veggies total: ' + str(veggies) + '   Fruits total: ' + str(fruits),
	print '   Vitamin: ' + str(vitamin) + '\n\n'
	check(cups_water, veggies, fruits)
	print 'Workout news:'
	workout(day)
	print_workout_info(day)
	print '\n\n'
	var = raw_input('(f) food; (d) saved food; (w) water; (c) workout; (r) restore previous session; (s) settings; (v) vitamin ')
	if var == 'f':
		food = raw_input('Enter the food ')
		if food == '':
			continue
		food = food.replace(' ', '_')
		while not calories.isdigit():
			calories = raw_input('Enter the calories ')
		while not sodium.isdigit():
			sodium = raw_input('Enter the sodium ')
		add = raw_input('Add food to saved foods list? (y/n) ')
		if add == 'y':
			add_to_foods_list(food, calories, sodium)
		var1 = raw_input('Fruit? (y); "Enter" for no ')
		if var1 == 'y':
			fruits = fruits + 1
		var1 = raw_input('Veggie? (y); "Enter" for no ')
		if var1 == 'y':
			veggies = veggies + 1
		save_dec = raw_input('Save? (y/n) ')
		if save_dec != 'y':
			continue
		check_dict(food)
		foods[food] = [int(calories), int(sodium)]
	if var == 'd':
		add_saved_foods()
	if var == 'w':
		while not water.isdigit():
			water = raw_input('How many cups of water? ')
		cups_water = cups_water + int(water)
	if var == '':
		print_totals()
	if var == 'r':
		if day_to_restore() != 'back':
			foods = {}
			restore()
	if var == 'c':
		workouts(day)
	if var == 's':
		settings()
	if var == 'v':
		if vitamin == 'no':
			vitamin = 'yes'
			save()
			save_workouts()
			save_foods_list()
			continue
		if vitamin == 'yes':
			vitamin = 'no'
	if var in ['f', 'd', 'w', 'c', 'r', 's', 'v']:
		save()
		save_workouts()
		save_foods_list()




