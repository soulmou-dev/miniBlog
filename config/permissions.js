export const PERMISSIONS = {
  GUEST: ['read_public'],
  USER: ['post.read', 'post.create', 'post.edit_own', 'post.delete_own'],
  ADMIN: [
    // Gestion des utilisateurs
    'user.manage',
    // Gestion des posts
    'delete_any_post',
  ],
};
