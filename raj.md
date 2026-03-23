Act as a professional web analytics and data logging system.

I want to collect and store website visitor data in JSON format with perfect structure and accuracy.

Rules:
1. All data must be saved inside a folder named: 
   websitedata/

2. Inside it, create a date-wise folder in this format:
   websitedata/YYYY-MM-DD/

3. For each visitor session, create one JSON file:
   websitedata/YYYY-MM-DD/session_<timestamp>.json

4. Store the following fields exactly:

{
  "ip": "",
  "page": "",
  "referrer": "",
  "browser": "",
  "screen": {
    "width": "",
    "height": ""
  },
  "language": "",
  "timezone": "",
  "visit_time": "",
  "location": {
    "latitude": "",
    "longitude": "",
    "country": "",
    "city": "",
    "region": "",
    "postal": "",
    "org": ""
  },
  "device": "",
  "interaction": {
    "element": "",
    "id": "",
    "class": "",
    "click_percent": "",
    "click_time": ""
  },
  "session": {
    "total_time": "",
    "time_spent": ""
  }
}

5. Data rules:
- visit_time must be in ISO format: YYYY-MM-DD HH:MM:SS  
- time_spent must be in seconds  
- timezone must be standard (e.g., Asia/Kolkata, UTC+05:30)  
- IP, browser, screen, language must be auto-detected  
- Location fields should be approximate only (city/country level)
- Every visit must generate a new JSON file
- No overwriting of old data

6. Folder example:
websitedata/
 └── 2026-01-16/
      ├── session_1705363452.json
      ├── session_1705363490.json

7. All stored data must be clean, readable, properly formatted JSON.
