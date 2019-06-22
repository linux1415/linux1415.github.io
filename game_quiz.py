#2-20-18
import os, random
english_history = '/home/jonathan/questions/quiz_england_questions.txt'
world_history = '/home/jonathan/questions/world_questions.txt'
world_history_2 = '/home/jonathan/questions/world_history_2.txt'
ww2_history = '/home/jonathan/questions/WW2_questions.txt'
random_file = '/home/jonathan/questions/random_questions.txt'
question_file = english_history
players = {}
used_questions = []
random_used_questions = []
all_quiz = []
file_quest_list = []
list_variables = [world_history, world_history_2, ww2_history, english_history]
saved = 'no'

random_list = open(random_file, 'r').read().split('[')
random_quiz = []
for x in random_list:
	x = x.replace(']', '').replace('\n', '').split('|')
	random_quiz.append(x)
del random_quiz[0]

def clear():
	os.system('clear')

def all_questions():   #adds question files to the list
	for item in file_quest_list:
		file = open(item, 'r').read().split('[')
		del file[0]
		for x in file:
			x = x.replace(']', '').split('|')
			quiz.append(x)

def add_players():   #to add players to game
	while True:
		clear()
		print 'Add Players\n'
		print 'Players: '
		for x in players.keys():
			print x
		print '\n\n'
		player = raw_input('Enter the players name; (d) when done. ')
		if player == 'd':
			break
		var = raw_input('Add ' + player + ' to game? (y/n) ')
		var = var.lower()
		if var == 'y':
			print 'Player ' + player + ' added.'
			players[player] = 0

def settings():   #the settings for the program
	count_reset = 'no'; questions_reset = 'no'; random_reset = 'no'; scores_reset = 'no'
	global count2, used_questions, random_used_questions
	def reset_scores():
		for x in players.keys():
			players[x] = 0
	def print_reset(a, b, c, d):
		if a == 'yes':
			print 'Count has been reset.'
		if b == 'yes':
			print 'Used questions have been reset.'
		if c == 'yes':
			print 'Random questions have been reset.'
		if d == 'yes':
			print 'Scores have been reset.'
		if a == 'yes' or b == 'yes' or c == 'yes' or d == 'yes':
			print '\n\n'
	while True:
		clear()
		print 'Settings\n\n'
		print_reset(count_reset, questions_reset, random_reset, scores_reset)
		var = raw_input('(a) reset scores; (b) new game; "Enter" to go back ')
		if var == '':
			return
		if var == 'a':
			var_a = raw_input('Reset all scores? (y/n) ')
			if var_a == 'y':
				reset_scores()
				scores_reset = 'yes'
		if var == 'b':
			while True:
				clear()
				print 'Settings\n\n'
				print_reset(count_reset, questions_reset, random_reset, scores_reset)
				var_b = raw_input('(a) reset question count; (b) reset used questions; (c) reset random questions; (d) reset all; "Enter" to go back ')
				if var_b == 'a':
					count2 = 0
					count_reset = 'yes'
				if var_b == 'b':
					used_questions = []
					questions_reset = 'yes'
				if var_b == 'c':
					random_used_questions = []
					random_reset = 'yes'
				if var_b == 'd':
					count2 = 0; used_questions = []; random_used_questions = []
					count_reset = 'yes'; questions_reset = 'yes'; random_reset = 'yes'
				if var_b == '':
					break
			
				

def category():   #the beginning screen; to choose quiz category
	global english_history, question_file, world_history, ww2_history, world_history_2, file_quest_list
	while True:
		clear()
		print_category()
		var = raw_input('\n\n(a) English History\n(b) World History\n(c) WW2 History\n(d) World History 2\n(s) All\n(x) to clear all\n\n"Enter" when done.\n\n\nChoice: ')
		if var == 'a':
			file_quest_list.append(english_history)
		if var == 'b':
			file_quest_list.append(world_history)
		if var == 'c':
			file_quest_list.append(ww2_history)
		if var == 'd':
			file_quest_list.append(world_history_2)
		if var == 's':
			file_quest_list = []
			for item in list_variables:
				file_quest_list.append(item)
		if var == 'x':
			file_quest_list = []
		if len(file_quest_list) < 1:
			print 'Please choose a category.'
			continue
		if var == '':
			break

def print_category():   #prints history category at the top of screen
	def print_():
		if len(file_quest_list) > 1:
			print '|',
	print 'Questions Category: ',
	for item in file_quest_list:
		if item == english_history:
			print 'England',
			print_()
		if item == world_history:
			print 'World',
			print_()
		if item == world_history_2:
			print 'World 2',
			print_()
		if item == ww2_history:
			print 'WW2',
			print_()
	print ''

def check_newline(x):   #replaces the "*" with a new line in the list from text file
	global possibilities
	if '*' in x:
		possibilities = x.replace('*', '\n')

def check_newline_q(x):   #replaces the "*" with a new line in the list from text file
	global question
	if '*' in x:
		question = x.replace('*', '\n')

def get_question():   #gets the question at random, making sure there are no duplicates
	global used_questions
	count = 0
	while True:
		count += 1
		if count > 5000:
			used_questions = []
		quest = (random.randint(0,(len(quiz)-1)))
		if quiz[quest] not in used_questions:
			return quiz[quest]
		else:
			continue
		

def points(x):   #decides how many points for question
	if len(x) > 3:
		score = x[3].strip()
	else:
		score = 5
	return score

def game_over_screen():   #the screen that appears when game ends
	clear()
	print 'Game Over!\n\n'
	print 'Scores\n' + '-' * 7
	for x,y in players.items():
		print x + ': ' + str(y)
	var = raw_input('\n\nPress Enter.')

def random_questions(person):   #gives a random fill in blank question during game
	num = (random.randint(0,3))
	quest = (random.randint(0,(len(random_quiz)-1)))
	#num = 3
	if num == 2:
		x = random_quiz[quest]
		if x in random_used_questions:
			return
		question = x[0].strip(); answer = x[1].strip().lower(); points = int(x[2].strip())
		'''if person == 'gary' or person == 'steve':
			points = int(points) / 2'''
		print 'Bonus!\n\nFor ' + str(points) + ' points:\n'
		var = raw_input(question + ' ')
		var = var.lower().strip()
		if var == answer:
			print '\nCorrect!'
			players[person] = players[person] + points
		else:
			print '\nIncorrect.'
		var2 = raw_input('\nPress Enter! ')
		random_used_questions.append(x)
		return 'yes'

def see_scores():   #to print out game scores
	clear()
	print 'Scores\n' + '-' * 7
	for x,y in players.items():
		print x + ': ' + str(y)
	var = raw_input('\n\n\nPress Enter. ')

clear()
category()
add_players()

while True:   #beginning loop; it opens text file of questions
	#file = open(question_file, 'r').read().split('[')
	quiz = []
	count = 0; count2 = 0
	'''for x in file:
		x = x.replace(']', '').split('|')
		quiz.append(x)
	del quiz[0]'''
	all_questions()
	while True:   #the game loop
		breakout = 'no'
		if saved != 'yes':
			count2 = 0
		clear()
		print 'History Quiz!'
		print_category()
		print 'Players: ',
		for x in players.keys():
			print x,
		var = raw_input('\n\n\nPress Enter to begin; (a) to choose different question category; (b) settings; (c) scores ')
		if var == 'a':
			category()
			break
		if var == 'b':
			settings()
		if var == 'c':
			see_scores()
		if var != '':
			continue
		clear()
		while True:
			for person,score in players.items():
				count3 = 0
				clear()
				if saved == 'yes':
					if person != saved_person:
						continue
				print 'Scores\n' + '-' * 7
				for x,y in players.items():
					print x + ': ' + str(y)
				print '\nPlayer: ' + person + '\n\n'
				count2 += 1
				if count2 > len(quiz):
					game_over_screen()
					breakout = 'yes'
					break
				if random_questions(person) == 'yes':
					count2 -= 1
					continue
				x = get_question()
				question = x[0].strip()
				possibilities = x[1].strip()
				answer = x[2].strip()
				check_newline(possibilities)
				check_newline_q(question)
				score = points(x)
				used_questions.append(x)
				'''if person == 'gary' or person == 'steve':
					score = int(score) / 2'''
				for q in range(2):
					count3 += 1
					if count3 == 2:
						score = int(score) / 2
					if count3 == 2:
						print '-'*100 + '\n\nSecond Try. You lose ' + str((int(score) * 2)) + ' points if you get the question wrong!\nPress "Enter" to pass.\n'
					print 'For ' + str(score) + ' points:\n'
					var = raw_input(str(count2) + '. ' + question + '\n' + possibilities + ' ')
					var = var.lower()
					if var == 'back':
						break
					if var == '':
						if count3 == 2:
							break
					if var == answer:
						print '\nCorrect!\n'
						enter = raw_input('Press Enter! ')
						count += 1
						players[person] = players[person] + int(score)
						if count3 == 1:
							break
					else:
						if count3 == 1:
							print '\nIncorrect!'
							if '(t)' in possibilities:
								enter = raw_input('\nPress Enter!')
								break
						else:
							print '\nIncorrect!\n'
						if count3 == 2:
							players[person] = players[person] - (int(score) * 2)
							print 'You lost ' + str((int(score) * 2)) + ' points!'
							enter = raw_input('Press Enter! ')
				if var == 'back':
					breakout = 'yes'
					saved_person = person
					saved = 'yes'
					count2 -= 1
					break
				saved = 'no'
			if breakout == 'yes':
				break

		#print 'You received a score of ' + str(count) + '/' + str(count2)

	
