export const ADMIN_IDS = [1, 10, 73, 43, 91];

export function getAuthUser() {
  const rawUser = localStorage.getItem("authUser");

  if (!rawUser) {
    return null;
  }

  try {
    return JSON.parse(rawUser);
  } catch (error) {
    return null;
  }
}

export function isAdminUser(userId) {
  const normalizedId = Number(userId);
  return ADMIN_IDS.includes(normalizedId);
}

export function clearAuthSession() {
  localStorage.removeItem("authUser");
}
