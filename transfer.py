import os, sys, os.path
from subprocess import call

list = sys.argv
list2 = []
for x in list:
	list2.append(x)
keep = []
command = 'cp'
extension = ''
all = 'no'

def check(x,y,z):
	global var
	if x == 'yes':
		var = 'y'
	if x != 'yes':
		return
	if z != '':
		if y.endswith(z) == True:
			keep.append(y)
	if z == '':
		keep.append(y)

if len(list) < 2:
	print 'Incorrect Output'
	sys.exit()

if not os.path.exists(list[1]) or not os.path.exists(list[2]):
	print 'Path does not exist'
	sys.exit()

if 'rm' in list:
	command = 'rm'
if 'mv' in list:
	command = 'mv'
if 'all' in list:
	all = 'yes'

input_folder = os.listdir(list[1])
output_folder = os.listdir(list[2])

while True:
	if list2[0] == '-ext':
		extension = list2[1]
		del list2[0:2]
	else:
		del list2[0]
	if len(list2) == 0:
		break

for x in input_folder:
	var = 0
	check(all, x, extension)
	while var not in ['y', 'n', '']:
		if extension == '':
			var = raw_input(x + '\nTransfer? (y/n) ')
			if var == 'y':
				keep.append(x)
		if extension != '':
			if x.endswith(extension) == True:
				var = raw_input(x + '\nTransfer? (y/n) ')
				if var == 'y':
					keep.append(x)
			else:
				break

for x in keep:
	path = os.path.join(list[1], x)
	call([command, path, list[2]])



		
