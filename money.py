import os, time, datetime
from operator import itemgetter
file = open('/home/jonathan/Documents/python_text_files/money_program/transactions', 'r').readlines()
file2 = open('/home/jonathan/Documents/python_text_files/money_program/monthly_payments', 'r').readlines()
credit_card = open('/home/jonathan/Documents/python_text_files/money_program/credit_cards', 'r').readlines()
credit_list = []
transactions = []
monthly_payments = []

def clear():
	os.system('clear')
	
def transactions_file(file): #puts info from text file into list
	this_month = datetime.date.today().strftime("%B")
	total = 0
	month_total = 0
	for x in file:
		x = x.strip()
		money, month, day_year, reason = x.split('|')
		list = [money, month, day_year, reason]
		transactions.append(list)
		if money[0] == '-':
			total -= float(money[1:])
			if month == this_month:
				month_total += float(money[1:])
		else:
			total += float(money)
	total_list = [total, month_total]
	return total_list
	
def credit_file(file): #puts info from text file into list
	this_month = datetime.date.today().strftime("%B")
	total = 0
	month_total = 0
	for x in file:
		x = x.strip()
		money, month, day_year, reason = x.split('|')
		list = [money, month, day_year, reason]
		credit_list.append(list)
		if money[0] == '-':
			total -= float(money[1:])
			if month == this_month:
				month_total += float(money[1:])
		else:
			total += float(money)
	total_list_credit = [total, month_total]
	return total_list_credit

def monthly_payments_file(file2): #puts info text file into list
	total = 0
	for x in file2:
		x = x.strip()
		money, reason = x.split('|')
		list = [money, reason]
		monthly_payments.append(list)
		total += float(money)
	return total
	
def add_to_list(choice, cat):
	if cat == 'debit':
		to_print = 'Debit:\n\n'
	else:
		to_print = 'Credit:\n\n'
	while True:
		clear()
		print to_print
		if cat != 'credit':
			var = raw_input('Enter (a) add; (s) subtract ')
			if var == '':
				return
		else:
			var = 's'
		if var == 'a':
			amount = raw_input('Enter amount: $').strip()
			if amount == '':
				continue
			if not amount.isdigit() and not amount.replace('.', '', 1).isdigit():	
				print 'Not allowed!'
				continue
		if var == 's':
			amount = raw_input('Enter amount: $').strip()
			if amount == '' and cat == 'debit':
				continue
			if amount == '' and cat == 'credit':
				return
			if not amount.isdigit() and not amount.replace('.', '', 1).isdigit():	
				print 'Not allowed'
				continue
			amount = '-' + str(amount)
		if var in ['a', 's']:
			if choice == 'b' or choice == 'd':
				reason = raw_input('Enter descritption: ').strip()
			else:
				reason = 'N/A'
			var2 = raw_input('Add information (y/n): ').strip()
			if var2 == 'y':
				month = datetime.date.today().strftime("%B")
				day = datetime.date.today().strftime("%d")
				year = datetime.date.today().strftime("%Y")
				day_year = str(day) + '-' + str(year)
				list = [amount, month, day_year, reason]
				if cat == 'debit':
					transactions.append(list)
					output = open('/home/jonathan/Documents/python_text_files/money_program/transactions', 'w')
					for item in transactions:
						a, b, c, d = item
						line = str(a) + '|' + str(b) + '|' + str(c) + '|' + str(d)
						output.write(line + '\n')
				if cat == 'credit':
					credit_list.append(list)
					output = open('/home/jonathan/Documents/python_text_files/money_program/credit_cards', 'w')
					for item in credit_list:
						a, b, c, d = item
						line = str(a) + '|' + str(b) + '|' + str(c) + '|' + str(d)
						output.write(line + '\n')
				output.close()

def print_money(x):
	clear()
	print("%-12s %-12s %-15s %-50s" % ('Amount', 'Month', 'Day/Year', 'Description'))
	print '-'*60
	#new = sorted(x, reverse=True)
	x2 = sorted(x, key=itemgetter(2))
	for item in x2:
		money, month, day_year, reason = item
		if month != datetime.date.today().strftime("%B"):
			continue
		print("%-12s %-12s %-15s %-50s" % (money, month, day_year, reason))
		#print("%-35s %-15s %1s" % (Class, num, credits))
	var = raw_input('\n\n\nPress Enter. ')

def print_monthly_payments(x):
	clear()
	print("%-12s %-12s" % ('Amount', 'Description'))
	print '-'*40
	for item in monthly_payments:
		money, des = item
		print("%-12s %-12s" % (money, des))	
	print '\nTotal: ' + str(x)
	var = raw_input('\n\nPress Enter. ')
	
def combined_list():
	big_list = []
	for x in transactions:
		big_list.append(x)
	for x in credit_list:
		big_list.append(x)
	big_list = sorted(big_list, key=itemgetter(2))
	#big_list.reverse()
	return big_list
				
		
		
trans_total, month_total = transactions_file(file)
monthly_pay_total = monthly_payments_file(file2)
credit_total, credit_month_total = credit_file(credit_card)

while True:
	clear()
	print 'Bank Account Total: ' + str(trans_total)
	print 'Monthly Debit Spending: ' + str(month_total)
	print 'Monthly Credit Spending: ' + str(credit_month_total)
	print '\n\n'
	print 'Debit\n' + '-'*20 + '\n(a) raw money\n(b) detailed money\n\n' + 'Credit\n' + '-'*20 + '\n(c) raw money\n(d) detailed money\n'
	print 'Print Outs\n' + '-'*20
	print '(e) monthly automatic payments\n(f) debit payments\n(g) credit payments\n'
	var = raw_input('Choice: ')
	if var == 'a':
		add_to_list(var, 'debit')
		file = open('/home/jonathan/Documents/python_text_files/money_program/transactions', 'r').readlines()
		file2 = open('/home/jonathan/Documents/python_text_files/money_program/monthly_payments', 'r').readlines()
		transactions = []
		trans_total, month_total = transactions_file(file)
	if var == 'b':
		add_to_list(var, 'debit')
		file = open('/home/jonathan/Documents/python_text_files/money_program/transactions', 'r').readlines()
		file2 = open('/home/jonathan/Documents/python_text_files/money_program/monthly_payments', 'r').readlines()
		transactions = []
		trans_total, month_total = transactions_file(file)
	if var == 'c':
		add_to_list(var, 'credit')
		credit_card = open('/home/jonathan/Documents/python_text_files/money_program/credit_cards', 'r').readlines()
		credit_list = []
		credit_total, credit_month_total = credit_file(credit_card)
	if var == 'd':
		add_to_list(var, 'credit')
		credit_card = open('/home/jonathan/Documents/python_text_files/money_program/credit_cards', 'r').readlines()
		credit_list = []
		credit_total, credit_month_total = credit_file(credit_card)
	if var == 'e':
		print_monthly_payments(monthly_pay_total)
	if var == 'f':
		print_money(transactions)
	if var == 'g':
		print_money(credit_list)
	if var == '':
		print_money(combined_list())
		
	

