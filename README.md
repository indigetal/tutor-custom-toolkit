## Tutor LMS Advanced Customization Toolkit

A powerful integration tool for Tutor LMS that extends its functionality by enabling advanced template overrides, metadata storage, role-based access controls, and dynamic data filtering for backend pages. Designed with flexibility in mind, this toolkit is perfect for developers and site owners who want to enhance Tutor LMS functionality.

---

### **Key Features**

1. **Granular Access Controls:**

   - Introduces new capabilities like `view_withdraw_requests`, `manage_orders`, and `view_subscriptions`.
   - Allows fine-grained control over access to backend pages for roles such as administrators and instructors.

2. **Dynamic Data Filtering:**

   - Filters data displayed on backend pages to ensure instructors only see data related to their own courses:
     - **Withdraw Requests:** Displays only withdraw requests from students in the instructor’s courses.
     - **Orders:** Shows only orders for the instructor’s courses.
     - **Subscriptions:** Lists only subscriptions tied to the instructor’s courses.

3. **Dynamic Template Override:**

   - Overrides the Tutor LMS custom template loader for the course archive page, restoring WordPress's default template hierarchy.

4. **Course Metadata Management:**

   - Automatically updates course metadata (e.g., average rating, rating count) when courses are saved or reviews are updated.

5. **Integration with Blocksy Content Blocks:**
   - Enables visual customization for the course archive page using Blocksy’s Content Blocks and the Gutenberg editor.

---

### **Use Cases**

This plugin is ideal if:

1. You’re using a theme like **Blocksy** or similar advanced frameworks with dynamic content design capabilities.
2. You want fine-grained access control and data filtering for Tutor LMS backend pages.
3. You need to extend Tutor LMS functionality with metadata management or additional dynamic template overrides.

---

### **New in Version 1.1.2**

1. **Granular Access Controls:**

   - Adds role-based capabilities for Withdraw Requests, Orders, and Subscriptions pages.

2. **Dynamic Data Filtering:**

   - Ensures that instructors only see data related to their own courses on backend pages.

3. **Improved Integration:**
   - Enhances the course archive override for seamless theme compatibility.

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
