import os, sys
in_file = 'ciphertext.txt'
key = 'alpha_key_1'
switch = sys.argv
if len(switch) == 2:
	in_file = switch[1]
input = open(in_file, 'r').read().split('|')
letter = []
file = open(key, 'r').read().replace(']', '')
file = file.split('[')
dict = {} ; letters = []

for x in file: 
	if x == '':
		continue
	a, b = x.split('|')
	dict[a] = b.split()

for x in input:
	for a, b in dict.items():
		if a == 'padding':
			continue
		if x in b:
			letters.append(a)
	string = ''.join(letters).replace('+', '\n')
print string

