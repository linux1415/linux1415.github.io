def convert(num):
	to_add = ''; add = 'no'; count = 0
	num = str(num)
	if '.' in num:
		a, b = num.split('.')
		new_num = b
		for item in new_num:
			if item != '0':
				add = 'yes'
			if add == 'yes':
				to_add += item
			else:
				count += 1
		new_num = to_add
		exponent = '-' + str(count + 1)
	else:
		new_num = num
		exponent = len(num) -1
	new = new_num[0] + '.' + new_num[1:]
	print new + ' * 10^' + str(exponent)
