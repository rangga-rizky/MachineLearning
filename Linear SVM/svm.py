def hitungSVM(trainings,testing):
	
	for training in trainings: #menambahkan bias
		training.append(1)

	a = []
	for training in trainings:
		sums = []
		for i in range(0,len(trainings)):
			sum = 0
			for j in range(0,len(training)):
				sum = sum + (int(training[j]) * int(trainings[i][j]))
			sums.append(sum)
		a.append(sums)

	y = [1,-1]
	y = np.matrix(y)
	a = np.matrix(a)
	a = a.I
	x = y * a
	x = x.tolist()[0]

	w = []
	for i in range(0,len(trainings[0])):
		sum = 0;
		for j in range(0,len(trainings)):
			sum = sum + (x[j] * int(trainings[j][i]))
		w.append(sum)
	w[len(w)-1] = w[len(w)-1] * -1
	#testing
	sum = 0
	for i in range(0,len(testing)):
		sum = sum + testing[i] * w[i]

	result = "Unknown"
	if sum > w[len(w)-1]:
		result = "Positive"
	elif sum < w[len(w)-1]:
		result = "Negative"	

	return result;