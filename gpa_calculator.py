#3-20-18
list = []
dict = {}
import os
def test(a):
	if a == 'a':
		list.append(4)
	if a == 'b':
		list.append(3)
	if a == 'c':
		list.append(2)
	if a == 'd':
		list.append(1)
	if a == 'f':
		list.append(0)

def print_grade(a):
	var = 'no'
	if a == 4:
		var = 'A'
	if a == 3:
		var = 'B'
	if a == 2:
		var = 'C'
	if a == 1:
		var = 'D'
	if a == 0:
		var = 'F'
	if var != 'no':
		return var

def add_dict(a):
	grade = raw_input('Enter the grade: ').lower().strip()
	if grade in ['a', 'b', 'c', 'd', 'f']:
		if grade == 'a':
			points = 4
		if grade == 'b':
			points = 3
		if grade == 'c':
			points = 2
		if grade == 'd':
			points = 1
		if grade == 'f':
			points = 0
		dict[a] = points	


while True:
	os.system('clear')
	print 'Type in A, B, C, D, or F for quick add.\n\n(r) to reset\n\n'
	if len(list) > 0 or len(dict) > 0:
		count = 0
		if len(list) > 0:
			for x in list:
				count += x
				print 'Grade: ' + print_grade(x)
		if len(dict) > 0:
			for x, y in dict.items():
				count += y
				print x + ': ' + print_grade(y)
		gpa = float(count) / (len(list) + len(dict))
		print '\nGPA: ' + str(round(gpa, 2)) + '\n\n'
	var = raw_input('Enter Class: ').strip()
	if var.lower() not in ['a', 'b', 'c', 'd', 'f', 'e', 'r']:
		add_dict(var)
		continue
	'''if var == 'e':
		add_dict()'''
	var = var.lower()
	if var == 'r':
		list = []
		dict = {}
	test(var)
	
