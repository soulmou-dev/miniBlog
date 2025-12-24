import { PERMISSIONS } from './permissions.js';

export const ROLES = {
  GUEST: {
    key: 'guest',
    label: 'Invité',
    assignable: false,
    permissions: PERMISSIONS.GUEST,
  },
  USER: {
    key: 'web_user',
    label: 'Utilisateur',
    assignable: true,
    permissions: [...PERMISSIONS.GUEST, ...PERMISSIONS.USER],
  },
  ADMIN: {
    key: 'admin',
    label: 'Administrateur',
    assignable: true,
    permissions: [
      ...PERMISSIONS.GUEST,
      ...PERMISSIONS.USER,
      ...PERMISSIONS.ADMIN,
    ],
  },
};
