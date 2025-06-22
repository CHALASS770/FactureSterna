<form action="save_expence.php" method="POST" enctype="multipart/form-data" dir="rtl">
    <label>שם החברה:</label><br>
    <input type="text" name="company_name" required><br><br>

    <label>תאריך תשלום:</label><br>
    <input type="date" name="payment_date" required><br><br>

    <label>סכום ששולם:</label><br>
    <input type="number" step="0.01" name="amount" required><br><br>

    <label>העלה את תמונת הקבלה:</label><br>
    <input type="file" name="receipt" accept="image/*,.pdf" required><br><br>

    <button type="submit">שמור הוצאה</button>
</form>
