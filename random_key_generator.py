from base64 import b64encode
from os import urandom
import string, sys
output_file = 'master_key'
command = sys.argv
if len(command) > 1:
	output_file = command[1]
num = 1000 #this must be one more than in the encrypt file; higher number, more secure
possibles = ['.', ',', '(', ')', ' ', '!', ':', '"', '\'', '+', '_', '^', '?', '*', '&', '%', '$', '#', '@', ';', '/', '-', '{', '}', '=', 'padding']
characters = string.ascii_letters + string.digits 
for x in characters:
	possibles.append(x)

used_list = []

final_dict = {}
count = 0
for item in possibles:
	count += 1
	print str(count) + '/' + str(len(possibles))
	temp_list = []
	for x in range(num):
		while True:			
			bytes = urandom(8)
			new = b64encode(bytes).decode('utf-8')
			new = new.replace('|', '#').replace(' ', '%').replace('\\', '_').replace('[', 'd').replace(']', 'i').replace('=', '')
			if new in used_list:
				continue
			used_list.append(new)
			temp_list.append(new)
			break
		final_dict[item] = temp_list
print str(len(final_dict))

output = open(output_file, 'w')

for x,y in final_dict.items():
	output.write('[' + x + '|'),
	for item in y:
		output.write(item + ' '),
	output.write(']')
output.close()
		

