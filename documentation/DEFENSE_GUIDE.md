# Demonstration and Defense Guide
1. Register and explain validation/password hashing.
2. Log in and explain sessions.
3. Browse events, countdowns and RSVP.
4. Submit Contact Us and verify Message Submissions.
5. Log in as admin and create/edit/delete an event.
6. Explain users, events, rsvps and contact_messages relationships.

Prepared statements prevent SQL injection. `htmlspecialchars` prevents stored values executing as HTML/JavaScript. The RSVP composite key prevents duplicate attendance. CSRF tokens stop forged state-changing requests.
