list = []
pal = 'ISAPALINILAPASI'
def check(a):
	count = -1
	string = ''
	for x in a:
		string += str(a[count])
		count -= 1
	if a == string:
		list.append(a)
		print a
		
count = 0; count2 = 3
for y in range(len(pal)):
	for x in pal:
		if count2+count > len(pal):
			break
		check(pal[count:(count+count2)])
		print str(count) + ':' + str(count2+count)
		count += 1
	count = 0
	count2 += 1
	
print list

biggest = ''
for x in list:
	if len(x) > len(biggest):
		biggest = x
print biggest
		

