import sys, os, readline

command = sys.argv
in_file = command[1]
file = open(in_file, 'r').read().split('\n')
dict = {}
cipher_list = []

for x in file[2:]:
	if '-' in x or x == '':
		continue
	y = x.split()
	x = x.split('|')
	dict[x[0][0]] =  x[0:]
	cipher_list.append([y[0][0], y[1].split()])
	
	
	
def enc(a, b, c):
	cipher = ''
	start = int(a)
	stop = int(b)
	os.system('clear')
	clear = ''
	count = start - 2
	while True:
		back = 'no'
		var = raw_input('Enter text: ').upper()
		if var == 'DONE':
			return
		for x in var:
			if x == ' ':
				continue
			clear += x
			if x not in dict.keys():
				back = 'yes'
				break
			if c == '-':
				count += 1
				for a,b in dict.items():
					if x == a:
						new = b[count]
				if ' ' in new:
					new2 = new.split()
					new = new2[1]
				cipher = cipher + new + ' '
				if count == stop - 1:
					count = start-2
		if back == 'yes':
			continue
		os.system('clear')
		print str(start) + c + str(stop) + '\n' + cipher + '\n'
		print clear + '\n\n'

def dec():
	plaintext = '' ; ciphertext = ''
	os.system('clear')
	while True:
		var = raw_input('Enter ciphertext: ').upper().strip()
		if var == 'DONE':
			return
		var = var.split()
		for item in var:
			for x,y in cipher_list:
				local_list = y[0].split('|')
				if item in local_list:
					plaintext = plaintext + x
					ciphertext += item
		os.system('clear')
		print plaintext + '\n' + '*'*len(ciphertext) + '\n' + ciphertext + '\n\n'
	
		
						
while True:
	os.system('clear')
	var = raw_input('(e) encrypt; (d) decrypt ')
	if var == 'e':
		#print str(size)
		var2 = raw_input('Enter the desired pattern (i.e. 1-10, 5-10, etc): ').strip()
		start, stop = var2.split('-')
		enc(int(start.strip()), int(stop.strip()), '-')
	if var == 'd':
		dec()
	
	
