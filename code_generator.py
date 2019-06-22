import string, os, sys
length = 3
keys = 3
command = sys.argv
if len(command) > 3:
	kind = command[1]
	length = int(command[2])
	keys = int(command[3])
if len(command) < 2:
	print 'CODE GENERATOR\n\n'
	var = raw_input('(a) uppercase; (b) digits; (c) both ')
	length = int(raw_input('Enter desired length of each ciphertext: ').strip())
	keys = int(raw_input('Enter desired number of keys per letter/number: ').strip())
else:
	if kind == 'digit' or kind == 'digits':
		var = 'b'
	if kind == 'letter' or kind == 'letters':
		var = 'a'
	if kind == 'both':
		var = 'c'
if var == 'a':
	include = string.uppercase
elif var == 'b':
	include = string.digits
	if length == 2:
		if keys != 1:
			keys = 2
	if length == 1:
		length = 2
		if keys != 1:
			keys = 2
elif var == 'c':
	include = string.digits + string.uppercase
	include = include.replace('0', '').replace('O', '').replace('I', '').replace('1', '').replace('5', '').replace('S', '')
else:
	sys.exit()
from base64 import b64encode
byte = 2048
final = []
letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.'
used_list = []

for x in letters:
	temp = ''; count = 0
	while True:
		num = os.urandom(byte)
		new = b64encode(num).decode('utf-8').replace('=', '')
		for a in new:
			if a not in include:
				new = new.replace(a, '')
		to_add = new[:length]
		if to_add in used_list:
			continue
		temp = temp + to_add
		used_list.append(to_add)
		count += 1
		if count == keys:
			break
		temp = temp + '|'
	final.append(x + ': ' + temp)
number = (length+1)*keys
if length%2 == 0:
	spaces = length/2
if length%2 != 0:
	spaces = length/2 + 1
counter = 1
to_print = '1'
for x in range(keys-1):
	counter += 1
	to_print += ' '*(length) + str(counter)
print 'CIPHER'
print '  ' + ' '*spaces + to_print
print '---' + '-'*number
for x in final:
	print x
	print '---' + '-'*number
var2 = ''
to_format = 'yes' #change to yes to break key into two sections
if len(command) < 2:
	var2 = raw_input('\n\nPrint to file: (y/n): ')
	if var2 != 'y':
		sys.exit()
	output_file = raw_input('Enter output file or press "Enter" to use the default "new_cipher.txt" file. ').strip()
	if output_file == '':
		output_file = 'new_cipher.txt'
if len(command) > 4 or var2 == 'y':
	if len(command) > 4:
		output_file = str(command[4])
	var = raw_input('Create ' + output_file + ' (y/n) ') #comment out if running from script
	#var = 'y'
	if var != 'y':
		sys.exit()
	file = open(output_file, 'a') #change to "a" to print to same file
	file.write('CIPHER\n')
	file.write('  ' + ' '*spaces + to_print)
	file.write('\n---' + '-'*number + '\n')
	counter = 0
	for x in final:
		counter += 1
		file.write(x + '\n')
		file.write('---' + '-'*number + '\n')
		if to_format == 'yes':
			if counter == len(letters)-19:
				file.write('  ' + ' '*spaces + to_print)
				file.write('\n---' + '-'*number + '\n')
	file.close()
	
	
	
	
	
	
	
	
	
	
