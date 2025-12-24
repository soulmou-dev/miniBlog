import { PERMISSIONS } from './permissions.js';

export const ROLES = {
  web_user: PERMISSIONS.WEB_USER,
  admin: [...PERMISSIONS.WEB_USER, PERMISSIONS.ADMIN],
};
