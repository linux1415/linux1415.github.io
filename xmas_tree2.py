#adjustable size christmas tree
import os
var = raw_input('Enter size: ').strip()
os.system('clear')
xmas = 'MERRYCHRISTMAS!!'
to_print = ''
spaces = 40; size = int(var); count = 1; count2 = size; xmas_count = 0
print ' '*(spaces+size-8) + 'Merry Christmas!!\n\n'
for x in range(size):	#tree
	to_print += ' '*spaces + ' '*size
	for x in range(count + (count-1)):
		to_print += xmas[xmas_count]
		xmas_count += 1
		if xmas_count == len(xmas):
			xmas_count = 0
	print to_print
	size -= 1
	count += 1
	to_print = ''
for x in range(3):	#stem
	for x in range(5):
		to_print += xmas[xmas_count]
		xmas_count += 1
		if xmas_count == len(xmas):
			xmas_count = 0
	print ' '*spaces + ' '*(count2-2) + to_print + ' '*(count2-2)
	to_print = ''
