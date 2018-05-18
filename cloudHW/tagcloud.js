function makeCloud() 
{
	textAreaNode = document.getElementById("tags").value;
	// whole string of textarea
	allTagsArray = textAreaNode.split(" "); // string array of all words
	allTagsArray = allTagsArray.sort();
	// parallel array
	uniqueTagsArray = new Array();
	// unique tags
	tagFreqArray = new Array();
	// frequency of EACH unique tag

	// fill in uniqueTagsArray and tagFreqArray
	for (var i = 0; i < allTagsArray.length; i++)
	{
		wordCounter = 0;
		currentWord = allTagsArray[i];

		if (currentWord == "duplicate")
			continue;

		for (var j = i; j < allTagsArray.length; j++)
		{
			if (allTagsArray[j] == "duplicate")
				continue;
			// first case of each unique tag
			else if (wordCounter == 0 && allTagsArray[j] == currentWord)
			{
				// guava case where frequency = 1
				if (allTagsArray[j+1] != currentWord && j < allTagsArray.length - 1)
					uniqueTagsArray.push(currentWord);

				wordCounter++; // always becomes 1
			}

			else if (allTagsArray[j] == currentWord)
			{
				// at the end of unique tag streak
				if (allTagsArray[j+1] != currentWord && j < allTagsArray.length - 1)
					uniqueTagsArray.push(currentWord);

				// case of very last tag (plum)
				else if (j == allTagsArray.length - 1)
				uniqueTagsArray.push(currentWord);

				wordCounter++;
				allTagsArray[j] = "duplicate";
			}
		}

		tagFreqArray.push(wordCounter);
	}

	// calls to functions here
	freqMax();
	makeDiv();

	// styling the div
	divNode.style.border = ".1em solid silver";
	divNode.style.backgroundColor = "blue";
	divNode.style.color = "silver";
	divNode.id="oldDiv";
	// spanNode.style.font = "24pt Georgia,serif";

	// remove old div and replace with new div
	var oldDivNode = document.getElementById("oldDiv");
	var nodeParent = oldDivNode.parentNode;
	nodeParent.replaceChild(divNode, oldDivNode);
}

function freqMax()
{
	maxFreq = tagFreqArray[0];
	for (var i = 0; i < tagFreqArray.length; i++)
	{
		if (tagFreqArray[i] > maxFreq)
			maxFreq = tagFreqArray[i];
	}
}

function makeDiv()
{
	divNode = document.createElement("div");

	// append each unique tag as text node to span element
	for (var i = 0; i < uniqueTagsArray.length; i++)
	{
		spanNode = document.createElement("span");
		var tagTextNode = document.createTextNode(uniqueTagsArray[i] + " ");
		spanNode.appendChild(tagTextNode);

		// change span font size
		if (tagFreqArray[i] != 1)
		{
			var size = (Math.floor((tagFreqArray[i] / maxFreq) * 20) + 15) + "pt";
			spanNode.style.font = size + " Georgia,serif";
		}

		else 
			spanNode.style.font = "15pt Georgia,serif";

		divNode.appendChild(spanNode);

		// onclick function: alert # times tag appears
		var alertString1 = uniqueTagsArray[i] + ": " + tagFreqArray[i] + " occurrences!";
		var alertString2 = "alert('" + alertString1 + "')";
		spanNode.setAttribute("onclick", alertString2);
	}
	return;
}

// reset textarea = keep global var of the entire beginning textarea then change
function clearArea()
{
	myTextAreaNode = document.getElementById("tags");
	myTextAreaNode.innerHTML = "";
}

function saveCloud()
{
	name = "newText"; // name part of the name-value pair of cookie
	document.cookie = name + "=" + document.getElementById("tags").value;
}

function loadCloud()
{
	cookieArr = document.cookie.split(';');
	for (var i = 0; i < cookieArr.length; i++)
	{
		var nvPairArr = cookieArr[i].split("=");
		if (nvPairArr[0] == "newText")
		{
			document.getElementById("tags").value = nvPairArr[1];
			return;
		}
	}
}







