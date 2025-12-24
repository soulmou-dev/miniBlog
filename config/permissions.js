export const PERMISSIONS = {
  WEB_USER: ['post.read', 'post.create', 'post.update', 'post.delete'],
  ADMIN: [
    // Gestion des utilisateurs
    'admin.user.read',
    'admin.user.create',
    'admin.user.update',
    'admin.user.delete',

    // Gestion des rôles / permissions
    'admin.permission.manage',
    'admin.role.manage',
  ],
};
