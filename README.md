# Email-Verification-System

# Email Verification System – GitHub Timeline Updates

This project is a pure PHP-based email verification system where users:

✅ Enter their email to register  
✅ Receive a 6-digit code for verification  
✅ Get GitHub timeline updates via email every 5 minutes (via CRON job)  
✅ Can unsubscribe via a secure verification link

📌 Key Features:
- Uses `registered_emails.txt` for verified users
- HTML email formatting
- GitHub timeline fetched and emailed (every 5 mins)
- Unsubscribe via link + code verification
- All logic inside `src/` (no database, no external libraries)

🧰 Built with core PHP, HTML, and a CRON job  
🧠 Follows assignment structure and naming conventions exactly
