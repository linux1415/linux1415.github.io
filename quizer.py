#version 7; asks questions at random; allows multiple text files, allows a finite number of questions, allows known questions to be temporarily discarded
#allows a focus group of questions that need to be worked on
#5-11-18
import os, sys, random, os.path
quiz = []
used_list = []
answers = []
num_to_ask = ''
focus_print = '(f) for focus questions; '
focus_print_2 = '(f) to focus on question; '
focus = 'no'

def num_add(x):
	input = open(x, 'r').readlines()
	output = open(x, 'w')
	count = 0
	for x in input:
		count += 1
		if x == '\n':
			continue
		x = x.strip().strip('\n').replace('\n', '')
		list = x.split('|')
		if len(list) == 3:
			del list[2]
		list.append(str(count))
		if len(list) < 3:
			continue
		new = '|'.join(list)
		output.write(new + '\n')
	output.close()

def reset():
	var = raw_input('Reset the excluded answers file? (y/n) ')
	if var == 'y':
		os.system('rm /home/jonathan/Documents/python_text_files/quizer_temp_file.txt')
		os.system('touch /home/jonathan/Documents/python_text_files/quizer_temp_file.txt')
		print 'File has been reset'
	var2 = raw_input('Reset the focus answers file? (y/n) ')
	if var2 == 'y':
		os.system('rm /home/jonathan/Documents/python_text_files/quizer_temp_focus_file.txt')
		os.system('touch /home/jonathan/Documents/python_text_files/quizer_temp_focus_file.txt')		
	var3 = raw_input('Press Enter ')

def add_temp_file_2(word, num):
	temp_file = open('/home/jonathan/Documents/python_text_files/quizer_temp_focus_file.txt', 'r').readlines()
	temp_file.append(word + num)
	output_file = open('/home/jonathan/Documents/python_text_files/quizer_temp_focus_file.txt', 'w')
	for x in temp_file:
		x = x.strip().replace('\n', '')
		output_file.write(x + '\n')
	output_file.close()
	
def add_temp_file(word, num):
	temp_file = open('/home/jonathan/Documents/python_text_files/quizer_temp_file.txt', 'r').readlines()
	temp_file.append((word + num))
	output_file = open('/home/jonathan/Documents/python_text_files/quizer_temp_file.txt', 'w')
	for x in temp_file:
		x = x.strip().replace('\n', '')
		output_file.write(x + '\n')
	output_file.close()
	
def add(x, y):
	file = os.path.join(y, files[x])
	num_add(file)
	list = open(file, 'r').readlines()
	for x in list:
		x = x.replace('[', '').replace(']', '').strip('\n')
		x = x.split('|')
		if x[0] != '':
			quiz.append(x)
			answers.append(x[1])

def print_answers(x):
	to_print.append(x.strip())
	count = 0
	for x in answers:
		if count == 9:
			break
		count += 1
		to_print.append(x.strip())
	random.shuffle(to_print)
	print '\n'
	for x in to_print:
		print x

arg = sys.argv
if os.path.exists(arg[1]) == False:
	sys.exit()
files = sorted(os.listdir(arg[1]))

while True:
	os.system('clear')
	for x in files:
		if x not in used_list:
			num = files.index(x)
			print str(num) + ': ' +  x
	print '\n\nAdded: '
	for x in used_list:
		print x
	var = raw_input('\n\nEnter number of the questions to ask. Start: (d) normal questions; (f) focus questions. ')
	if var == 'reset':
		reset()
	if var == 'd' or var == 'f':
		if var == 'f':
			focus = 'yes'
			focus_print = '(b) back to normal questions; '
			focus_print_2 = ''
		break
	if var.isdigit():
		var = int(var)
	else:
		continue
	add(var, arg[1])
	used_list.append(files[var])

while not num_to_ask.isdigit():
	num_to_ask = raw_input('(a) for all; or enter the number of questions to ask. ')
	if num_to_ask == 'a':
		break

count2 = 0
while True:
	back = 'no'
	if count2 > 0:
		os.system('clear')
		go = raw_input('Press "Enter" to continue with another round; ' + focus_print + '(q) to exit ')
		if go == 'reset':
			reset()
			continue
		if go == 'q':
			sys.exit()
		if go.strip() != '' and go != 'f' and go != 'b':
			continue
		if go == 'f':
			focus = 'yes'
			focus_print = '(b) back to normal questions; '
			focus_print_2 = ''
		if go == 'b':
			focus = 'no'
			focus_print = '(f) for focus questions; '
			focus_print_2 = '(f) to focus on question; '
	count2 += 1
	count = 0
	random.shuffle(quiz)
	for item in quiz:
		exclude_list = open('/home/jonathan/Documents/python_text_files/quizer_temp_file.txt', 'r').read().split('\n')
		focus_list = open('/home/jonathan/Documents/python_text_files/quizer_temp_focus_file.txt', 'r').read().split('\n')
		count += 1
		if num_to_ask != 'a':
			if count > int(num_to_ask):
				break
		num = str(count) + '. '
		os.system('clear')
		question = item[0].strip().replace('*', '\n')
		if num == question[:3]:
			num = ''
		answer = item[1].strip().replace('*', '\n\n')
		unique_num = item[2].strip()
		if (answer + unique_num) in exclude_list:
			count -= 1
			continue
		if focus == 'yes':
			if (answer + unique_num) not in focus_list:
				count -= 1
				continue
		while True:
			to_print = []
			var = raw_input(focus_print_2 + '(d) to discard question; (a) for word bank\n\n\nQuestion:\n\n' + num + question + '   ')
			print '-'*100
			if var == 'menu':
				back = 'yes'
				break
			if var == '':
				break
			if var == 'a':
				print_answers(answer)
				print '\n'
				var2 = raw_input()
				if var2 == '':
					break
			if var == 'd':
				add_temp_file(answer, unique_num)
				break
			if var == 'f':
				add_temp_file_2(answer, unique_num)
				break
			os.system('clear')
		if back == 'yes':
			break
		if var != 'd' and var != 'f':
			print ('\n\n' + answer)
		if var == 'd' or var == 'f':
			print '\n\n'
			if var == 'd':
				print 'Question added to discard list.'
			if var == 'f':
				print 'Question added to focus-on list.'
		var = raw_input('\n\nPress Enter! ')
		if var == 'd':
			add_temp_file(answer, unique_num)
		if var == 'f':
			add_temp_file_2(answer, unique_num)
