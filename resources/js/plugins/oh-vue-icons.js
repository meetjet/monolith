import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as RiIcons from "oh-vue-icons/icons/ri";

const Ri = Object.values({ ...RiIcons });
addIcons(...Ri);
export const icons = OhVueIcon;
