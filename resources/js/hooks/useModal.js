import {modals} from "../flags/Flags";
import useFlag from "./useFlag";

export default function useModal(name) {
    const key = modals().open(name);
    const [get, set] = useFlag(key);

    const open = () => set(true);
    const close = () => set(false);

    return [open, close, get()];
}