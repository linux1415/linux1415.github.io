#1-19-18
import os, readline
from subprocess import call

astr_file = 'Documents/python_text_files/astr.txt'
chem_file = 'Documents/python_text_files/chem.txt'
chem_lab_file = 'Documents/python_text_files/chem_lab.txt'
net_sec = 'Documents/python_text_files/net_sec.txt'
list_of_files = {astr_file: 'Astronomy', chem_file: 'Chemistry Lecture', chem_lab_file: 'Chemistry Lab', net_sec: 'Network Security'}

def clear():
	os.system('clear')

def open_file(a):
	global file
	file = open(a, 'r').readlines()
	for x in file:
		new = x.replace('\n', '')
		list.append(new)

def show_file(a, course):
	global modified
	while True:
		clear()
		print course + ' Assignments:\n\n'
		for x in list:
			index = list.index(x)
			print str(index) + '. ' + x
		var = raw_input('\n\nType (a) add, (d) to delete; or type in number to mark assignment done. ')
		if var == '':
			return
		if var == 'd':
			to_delete = raw_input('Type the number of the assignment to delete. ')
			if to_delete.isdigit() and int(to_delete) <= len(list):
				del list[int(to_delete)]
				modified = 'yes'
		if var.isdigit() and int(var) <= len(list):
			list.append(str(list[int(var)]) + '     Done!')
			del list[int(var)]
			modified = 'yes'
		if var == 'a':
			assignment = raw_input('Enter the assignment description. ').strip()
			if assignment == '':
				continue
			due_date = raw_input('Enter the due date. ').strip()
			if due_date == '':
				continue
			item = assignment + ': ' + due_date
			list.append(item)
			modified = 'yes'

def close_file(a):
	if modified == 'yes':
		new_file = open(a, 'w')
		for x in list:
			new_file.write(x + '\n')
		new_file.close()
			

while True:
	list = []
	modified = 'no'
	enter = 0
	clear()
	var = raw_input('My Assignment Tracker!\nBe Sure To Update Assignments Every Sunday!\n\n\nCourses:\n\n(a) Astronomy; (b) Chemistry Lecture; (c) Chemistry Lab; (d) Network Security ')
	if var == 'a':
		course = 'Astronomy'
		open_file(astr_file)
		show_file(astr_file, course)
		close_file(astr_file)
	if var == 'b':
		course = 'Chemistry Lecture'
		open_file(chem_file)
		show_file(chem_file, course)
		close_file(chem_file)
	if var == 'c':
		course = 'Chemistry Lab'
		open_file(chem_lab_file)
		show_file(chem_lab_file, course)
		close_file(chem_lab_file)
	if var == 'd':
		course = 'Network Security'
		open_file(net_sec)
		show_file(net_sec, course)
		close_file(net_sec)
	if var == '':
		clear()
		for x,y in list_of_files.items():
			print y
			for number in range(15):
				print '-',
			print ''
			call(['cat', x])
			print '\n\n'
		while enter != '':
			enter = raw_input('\nPress "Enter" when done! ')

	
















