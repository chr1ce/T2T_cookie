relevant_cat = ["angry","sad","frustrated", "disgusted", "afraid"]
categories = ["angry","sad","frustrated","appreciative","amused","content","disgusted","afraid","happy","relieved","surprised"]
result = ai_categorize(msg, categories)

if not is_before_ticket_submit:
	for phrase in relevant_cat:
		if phrase in result["matches"]:

			tier2assist.append({'msg':'Would you like a cookie?','action': 'http://localhost/cookie_form.php'})