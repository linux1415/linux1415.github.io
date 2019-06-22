import os, datetime
file = open('Documents/python_text_files/weight.txt', 'r').readlines()
month = datetime.date.today().strftime("%B")
day = datetime.date.today().strftime("%d")
list = []
list2 = []

for x in file:
	if x == '' or x == '\n':
		continue
	x1, x2 = x.split('|')
	list.append(x1.strip())
	list2.append(x2.strip())
	
def lost():
	temp_list = []
	for x in list[-3:]:
		temp_list.append(float(x))
	digit = sum(temp_list) / 3
	amount_lost = float(list[0]) - digit
	amount_lost2 = float(list[0]) - float(list[-1])
	lost_list = [amount_lost, amount_lost2]
	return lost_list

def add(x, month, day):
	file = open('Documents/python_text_files/weight.txt', 'w')
	for item in list:
		num = list.index(item)
		print str(num)
		file.write(item + ' | ' + list2[num] + '\n')
	file.write((str(x) + ' | ' + month + '_' + day + '\n'))
	file.close()
	file2 = open('Documents/python_text_files/weight.txt', 'r').readlines()
	local_list = []
	local_list2 = []
	for x2 in file2:
		if x2 == '' or x2 == '\n':
			continue
		var, var2 = x2.split('|')
		local_list.append(var.strip())
		local_list2.append(var2.strip())
	return [local_list, local_list2]

def progress():
	os.system('clear')
	print 'Daily Progress\n\n'
	count = 0
	for x in range(len(list)):
		print list2[count] + ': ' + list[count]
		count += 1
	var = raw_input('\n\nPress Enter: ')
	if var == '':
		return		
		
	
	
		
	
while True:
	os.system('clear')
	print 'Weight Loss Tracker\n\n'
	if len(list) > 3:
		avg_loss, loss = lost()
		print 'Lost based on average of last three entries: ' + str(round(avg_loss, 2)) + ' pounds'
		print 'Lost based on last entry: ' + str(loss) + ' pounds'
	else:
		if len(list) > 1:
			print 'Amount lost subtracting the last entry only: ' + str(float(list[0]) - float(list[-1])) + ' pounds'
	print '\n\n(a) Add new entry\n'
	var = raw_input(': ')
	if var == 'a':
		a = raw_input('Enter weight: ')
		if not a.isdigit() and not a.replace('.', '', 1).isdigit():	
			continue
		list, list2 = add(a, month, day)
	if var == '':
		progress()
