# Gradebook User Manual & Operational Guide

This document provides a clear, non-technical explanation of how the new Gradebook module functions, ensuring Administrators and Teachers can use it effectively.

---

## 1. Teacher Workflow: How to Enter Marks

### **Where to Start?**
- **Navigate to:** Teacher Dashboard → **Gradebook** (Menu Item).
- **Select:** The Class and Subject you wish to grade.
- **View:** You will see the **Gradebook Grid** listing all students and assessment columns.

### **Editing Rules**
- **Editable Columns (**White Background**):** You can click and type marks directly into these cells (e.g., Oral, Participation, Projects).
- **Saving:** Marks are **saved automatically** when you click outside the cell (Focus Out) or press Enter. A green indicator confirms the save.
- **Read-Only Columns (**Gray Background**):** You cannot edit these. They display marks from Exams and Homeworks managed elsewhere.

### **The "Locked" State**
- If the Administrator has **LOCKED** the gradebook for this class, you will see a **yellow warning banner** at the top.
- All input fields will be disabled (grayed out). You can view marks but cannot change them.

---

## 2. Understanding Gray "Read-Only" Columns

> *"Data in gray (like Exams and Homework) is managed from its own pages and appears here for review only."*

### **Why are they read-only?**
- **Source of Truth:** Exams and Homeworks are complex events (timers, question banks, online submissions). Their data "lives" in the **Online Exams** and **Homework** modules.
- **Data Safety:** To prevent conflicts (e.g., changing a mark here while a student is taking a quiz), we allow editing *only* at the source.
- **Workflow:** Even though you can't edit them *here*, the Gradebook **reads them live**. If you grade a quiz in the "Exams" section, the mark appears in the Gradebook instantly upon refresh.

---

## 3. Administrator Control: Locking & Opening

### **How to Control Access**
1.  **Navigate to:** Admin Panel → Gradebook → **View Subjects** (for a specific Class Room).
2.  **Action:** Look for the button at the top right: **"Lock Gradebook"** or **"Open Gradebook"**.
3.  **Scope:** This action applies to the **Entire Class** for the **Current Term**.

### **What happens when Locked?**
- **Admins:** Still have full control.
- **Teachers:** Immediately lose edit access.
    - If a teacher is currently on the page, the next time they try to save, they will get an error.
    - If they refresh, the page becomes read-only.
- **Use Case:** Lock the gradebook after the "Grade Submission Deadline" to prevent further changes before report cards are generated.

---

## 4. Legacy Data & Integrity

### **Is Old Data Safe?**
- **YES.** The new Gradebook is built *on top of* the existing system.
- **No Duplication:** We do not copy data. When you open the Gradebook, it looks directly at the `exams` and `results` tables used by the old system.
- **Consistency:** Because there is only one database table storing marks, the Gradebook and the Old Exam Pages will **always** show the same numbers.

### **Guarantee**
- **"Dynamic" Marks** (Oral/Activity) are stored in a special container that does not interfere with old exams.
- **"Legacy" Marks** (Quizzes/Exams) are protected and never touched by the Gradebook's save function.

---

## 5. The "Single Source of Truth"

### **Consistency Check**
- **If a school keeps using the old Exam Pages:** The Gradebook handles this perfectly. It simply acts as a "live viewer" for those marks.
- **Final Totals:** The **Gradebook Total** column is the authoritative sum.
    - Formula: `Total = (Sum of Exam Page Marks) + (Sum of Gradebook Grid Marks)`
    - This calculation happens live every time the page loads.

### **Summary Table**

| Feature | Managed In (Write Access) | Gradebook View |
| :--- | :--- | :--- |
| **Exams / Quizzes** | Old Exam/Quiz Pages | ✅ Read-Only (Gray) |
| **Homework** | Old Homework Pages | ✅ Read-Only (Gray) |
| **Oral / Activity** | **New Gradebook Grid** | ✅ Editable (White) |
| **Final Total** | Calculated Live | ✅ Display Only |

---
