#!/bin/bash

CRON_JOB="*/5 * * * * php $(pwd)/cron.php"
CRONTAB_CONTENT=$(crontab -l 2>/dev/null)

# Add only if not already present
if ! echo "$CRONTAB_CONTENT" | grep -qF "$CRON_JOB"; then
    (crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -
    echo "✅ CRON job scheduled successfully!"
else
    echo "ℹ️ CRON job already exists."
fi
