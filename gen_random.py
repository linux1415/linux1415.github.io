import os, sys, string
from base64 import b64encode
from os import urandom
from random import randint
characters = string.ascii_letters + string.digits
chars = []
for x in characters:
	chars.append(x)
numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
hex_nums = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f']
duplicates = 'yes'
used_list = []
list = sys.argv

def check(item, char_list, length):
	while len(item) < length:
		num = randint(0, len(char_list)-1)
		item += str(char_list[num])
	while len(str(item)) > length:
		item = item[:-1]
	return item

length = 10; coding = 'chars'; amount = 1; byte = 8; add_numbering = 'no'

if '-length' in list:
	num = list.index('-length')
	length = list[num + 1]
	byte = int(length)*2
	
if '-type' in list:
	num = list.index('-type')
	coding = list[num + 1]

if '-amount' in list:
	num = list.index('-amount')
	amount = list[num + 1]

if '-bytes' in list:
	num = list.index('-bytes')
	byte = int(list[num + 1])

if '-numbering' in list:
	add_numbering = 'yes'

if '-no-dup' in list:
	duplicates = 'no'

if '-print' in list:
	num = list.index('-print')
	print_file = list[num + 1]
	to_print = open(print_file, 'w')


strings = []
counter = 0
for x in range(int(amount)):
	counter += 1
	if '-print' in list and '-no-format' in list:
		if counter % 5000 == 0:
			print str(counter)
	while True:
		num = os.urandom(byte)
		if coding == 'digit':
			new = int(num.encode('hex'),16)
			if '-bytes' not in list:
				new = check(str(new), numbers, int(length))
		if coding == 'hex':
			new = num.encode('hex')
			if '-bytes' not in list:
				new = check(new, hex_nums, int(length))
		if coding == 'base64':
			new = b64encode(num).decode('utf-8')
			if '-bytes' not in list:
				new = check(new, chars, int(length))
		if coding == 'chars':
			new = b64encode(num).decode('utf-8')
			for x in new:
				if x not in chars:
					new = new.replace(x, '')
			new = check(new, chars, int(length))
		if duplicates == 'no':
			if new in used_list:
				continue
			else:
				break
		else:
			break
	strings.append(new)
	if duplicates == 'no':
		used_list.append(new)

count = 0
def format_nums(x):
	while len(str(x)) < len(str(len(strings))):
		x = '0' + str(x)
	return x
	
for x in strings:
	if '-no-format' in list:
		if '-print' in list:
			to_print.write(str(x) + " ")
		else:
			print str(x),
		continue
	count += 1
	if add_numbering == 'yes':
		print str(format_nums(count)) + ': ' + str(x) + '   ',
	if '-lined' in list:
		if add_numbering != 'yes':
			print str(x)
		else:
			print ''
		print '-'*55
		continue
	if add_numbering != 'yes' and '-lined' not in list:
		print str(x) + '   ',
	if count % 3 == 0:
		print ''
if '-print' in list:
	to_print.close()
