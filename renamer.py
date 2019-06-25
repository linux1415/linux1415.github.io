#mint 11-30-17
#sample command: python renamer.py Desktop/music "Two Steps From Hell - " "Two Steps From Hell"
#removes the desired phrase from all files within a given folder
list = []

import os.path, os, sys
arg = sys.argv
if len(arg) < 2:
	print 'No Input'
	sys.exit()
folder = arg[1]
if os.path.exists(folder) == False:
	print 'Path does not exist'
	sys.exit()
if len(arg) > 2:
	for x in arg[2:]:
		list.append(x)
input = raw_input('\nAre you sure? (y/n) ')
print '\n'
if input != 'y':
	sys.exit()
for y in list:
	for x in os.listdir(folder):
		if y in x:
			old = folder + '/' + x
			new = folder + '/' + x.replace(y,'')
			os.rename(old, new)
			print x + ' renamed to ' + str(os.path.basename(new))
