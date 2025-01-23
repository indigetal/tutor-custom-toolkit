## Tutor LMS Advanced Customization Toolkit

A powerful integration tool for Tutor LMS that extends its functionality by enabling advanced template overrides, metadata storage, and dynamic data filtering for backend pages. Designed with flexibility in mind, this toolkit is perfect for developers and site owners who want to enhance Tutor LMS functionality.

---

### **Key Features**

1. **Dynamic Data Filtering:**

   - Filters data displayed on backend pages to ensure instructors only see data related to their own courses:
     - **Withdraw Requests:** Displays only withdraw requests from students in the instructor’s courses.
     - **Enrollment:** Shows only enrollments for the instructor’s courses.
     - **Gradebook:** Lists only gradebook data tied to the instructor’s courses.
     - **Reports:** Restricts reports to the instructor’s courses and students.

2. **Dynamic Template Override:**

   - Overrides the Tutor LMS custom template loader for the course archive page, restoring WordPress's default template hierarchy.

3. **Course Metadata Management:**

   - Automatically updates course metadata (e.g., average rating, rating count) when courses are saved or reviews are updated.

4. **Integration with Blocksy Content Blocks:**
   - Enables visual customization for the course archive page using Blocksy’s Content Blocks and the Gutenberg editor.

---

### **Use Cases**

This plugin is ideal if:

1. You’re using a theme like **Blocksy** or similar advanced frameworks with dynamic content design capabilities.
2. You want dynamic data filtering for Tutor LMS backend pages to ensure proper access control.
3. You need to extend Tutor LMS functionality with metadata management or additional dynamic template overrides.

---

### **New in Version 1.2.1**

1. **Dynamic Data Filtering:**

   - Ensures that instructors only see data related to their own courses on backend pages such as Withdraw Requests, Enrollment, Gradebook, and Reports.

2. **Improved Integration:**

   - Enhances the course archive override for seamless theme compatibility.

3. **Streamlined Approach:**
   - Refactored to leverage Tutor LMS’s existing `manage_tutor` capability, simplifying access control.

---

### **Notes**

- This plugin **targets specific templates and backend pages** for override and filtering, ensuring compatibility and minimizing conflicts with Tutor LMS’s default behavior.
- Metadata updates and access controls are seamlessly integrated with Tutor LMS’s built-in functionality.

---

### **Requirements**

- WordPress 5.8 or higher.
- Tutor LMS (latest version recommended).

---

### **Installation**

1. Upload the plugin folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. The plugin will automatically initialize its custom functionality, including template overrides, metadata management, and backend page filtering.

---

This plugin is designed and maintained by Brandon Meyer, providing a flexible and powerful toolkit for advanced Tutor LMS customizations.
