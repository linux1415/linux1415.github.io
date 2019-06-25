#12-10-17
#type "all" to display all duplicates
#type "del" to enable delete option
import os, os.path, sys

words = ['the', 'a', '', ' ', 'of', 'and']
length = 2

arg = sys.argv

if os.path.exists(arg[1]) == False:
	sys.exit()

if len(arg) > 2:
	if arg[2].isdigit():
		length = int(arg[2]) - 1

list = os.listdir(arg[1])
list2 = []
big_list = []
dict = {}
dict2 = {}
count2 = 0
count3 = 0

def add(x):
	dict[count3] = x
	

for x in list:
	temp_list = []
	if count2 > 0:
		print ''
	count = 0
	count2 = 0
	file_underscore_lower = x.replace(' ', '_').lower().replace('-', '_').replace('(', '').replace(')', '').replace('[', '').replace(']', '')
	file_list = file_underscore_lower.split('_')
	for y in list:
		count = 0
		file_underscore_lower2 = y.replace(' ', '_').lower().replace('-', '_').replace('(', '').replace(')', '').replace('[', '').replace(']', '')
		file_list2 = file_underscore_lower2.split('_')
		for z in file_list2:
			if z in file_list and z not in words and file_underscore_lower2 != file_underscore_lower:
				count += 1
		if count > int(length):
			temp_list.append(y)
			
	dict2[x] = temp_list

for x,y in dict2.items():
	count2 = 0
	if len(y) > 0:
		if 'all' in arg:
			count3 += 1
			count2 += 1
			if 'del' in arg:
				add(x)
				print str(count3) + ' ' + str(dict[count3])
			if 'del' not in arg:
				print x
		if x not in big_list and 'all' not in arg:
			count3 += 1
			count2 += 1
			if 'del' in arg:
				add(x)
				print str(count3) + ' ' + str(dict[count3])
			if 'del' not in arg:
				print x
			big_list.append(x)
		for a in y:
			if 'all' in arg:
				count3 += 1
				count2 += 1
				if 'del' in arg:
					add(a)
					print str(count3) + ' ' + str(dict[count3])
				if 'del' not in arg:
					print a
			if a not in big_list and 'all' not in arg:
				count3 += 1
				count2 += 1
				if 'del' in arg:
					add(a)
					print str(count3) + ' ' + str(dict[count3])
				if 'del' not in arg:
					print a
				big_list.append(a)
	if count2 > 0:
		print ''

print '\n' + str(count3)

if 'del' in arg:
	print 'Type "done" when finished'
	while True:
		var = raw_input('Enter the number: ')
		if var == 'done':
			break
		for x,y in dict.items():
			if str(var) == str(x):
				file = os.path.join(arg[1], '"' + str(y) + '"')
				os.system('rm ' + file)
				path = os.path.join(arg[1], str(y))
				if os.path.exists(path) == False:
					print 'Successfully Deleted'

				
				


