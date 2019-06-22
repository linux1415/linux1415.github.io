from random import randint
import os, readline, sys
key = 'alpha_key_1'
file = open(key, 'r').read().replace(']', '')
file = file.split('[')
dict = {}
list =[]; letters = []
num = 9999 #this must be 1 less than the num variable in the key generator file

def padding():
	padding_num = randint(0, 10)
	if padding_num == 3:
		return 'yes'

def ch_mode(a, b):
	if a == 'mode':
		if b == 'continuous':
			return '0'
		else:
			return '1'

def print_file():
	var2 = raw_input('\n\nPrint to textfile? (y/n) ')
	if var2 == 'y':
		name = raw_input('Use "ciphertext.txt" file? (y); or (n) to use another name. ')
		if name == 'y':
			output_file = 'ciphertext.txt'
		else:
			output_file = raw_input('Enter desired name for file: ').strip().replace(' ', '_')
			output_file = output_file + '_ciphertext.txt'
		output = open(output_file, 'w')
		for x in list:
			output.write(x + '|')
		output.close()
		print output_file + ' created.'
		var3 = raw_input('\nPress Enter to continue; (q) to quit. ')
		if var3 == 'q':
			sys.exit()
		else:
			return ''
		

for x in file: 
	if x == '':
		continue
	a, b = x.split('|')
	dict[a] = b.split()

os.system('clear')
var3 = 'q'; mode_type = ''
begin1 = 'TEXT ENCRYPTER\n' + '-'*16 + '\n\n'
begin2 = 'Enter text; Type "done" to quit.\n'
print begin1, begin2
count = 0; var = ''
while True:
	count += 1
	back = 'no'
	#if count != 1:
		#os.system('clear')
	if var3 == '':
		os.system('clear')
		print begin1, begin2
		var3 = ' '
	var = raw_input(': ').strip()
	if var == 'mode':
		if ch_mode(var, mode_type) == '0':
			mode_type = ''
		else:
			mode_type = 'continuous'
		continue
	if var != 'done':
		if mode_type != 'continuous':
			list = []
			letters = []
		for item in var:
			rand_num = randint(0, num)
			if item not in dict.keys():
				'''back = 'yes'
				print item + ' not allowed\n'
				go_back = raw_input('Press Enter ')
				break'''
				item = '*'
			list.append(((dict[item])[rand_num]))
			if padding() == 'yes': #inserts padding so length of ciphertext will not equal length of plaintext
				list.append(((dict['padding'])[rand_num]))
		if back == 'yes':
			continue
		for x in list:
			for a, b in dict.items():
				if a == 'padding':
					continue
				if x in b:
					letters.append(a)
		string = ''.join(letters).replace('+', '\n')
		ciphertext = '|'.join(list)
		os.system('clear')
		print 'Ciphertext:\n' + ciphertext
		print '\n\nPlaintext:\n' + string + '\n'
	else:
		var3 = print_file()
	
		
		
	



	
