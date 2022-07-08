/**
 * Checks if the current user has the specified role.
 *
 * @param {String} role
 * @return {boolean}
 */
export function hasRole(role) {
    return this.$page.props.user
        ? this.$page.props.user.roles_list.indexOf(role) >= 0
        : false;
}

/**
 * Checks if the current user has the specified permission.
 *
 * @param {String} permission
 * @return {boolean}
 */
export function hasPermission(permission) {
    return this.$page.props.user
        ? this.$page.props.user.permissions_list.indexOf(permission) >= 0
        : false;
}
