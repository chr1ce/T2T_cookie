relevant_cat = ["angry","sad","frustrated", "disgusted", "afraid"]
categories = ["angry","sad","frustrated","appreciative","amused","content","disgusted","afraid","happy","relieved","surprised"]
result = ai_categorize(msg, categories)

if not is_before_ticket_submit:
	for phrase in relevant_cat:
		if phrase in result["matches"]:
			tier2assist.append({'msg':'Would you like a cookie?','action':'https://www.youtube.com/watch?v=e1xCU9ydG-A'})

# Alternatively, 'if any()' may be used to avoid production of multiple assists.
# e.g.
# if any(phrase in relevant_cat for phrase in result["matches"]):
