## Tutor LMS Advanced Customization Toolkit

A powerful integration tool for Tutor LMS that extends its functionality by enabling advanced template overrides, metadata storage, and dynamic data filtering for backend pages. Designed with flexibility in mind, this toolkit is perfect for developers and site owners who want to enhance Tutor LMS functionality.

---

### **Key Features**

1. **Hook-Based Data Filtering:**

   - Uses Tutor LMS’s hooks and filters to ensure instructors only see data related to their own courses:
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

### **New in Version 1.2.2**

1. **Hook-Based Data Filtering:**

   - Refactored to use Tutor LMS’s built-in hooks and filters for data retrieval on backend pages such as Withdraw Requests, Enrollment, Gradebook, and Reports.
   - Improved compatibility with Tutor LMS updates by removing reliance on custom controllers.

2. **Centralized Utility Functions:**

   - Introduced a shared `utils.php` file for reusable utility functions, improving maintainability.

3. **Improved Organization:**

   - Reorganized codebase to separate hook logic into dedicated files for better readability and modularity.

4. **Enhanced Performance:**
   - Streamlined the data filtering process by leveraging WordPress’s native query mechanisms through Tutor LMS hooks.

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
