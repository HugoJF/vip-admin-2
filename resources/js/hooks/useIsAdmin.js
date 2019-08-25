import useAuth from "./useAuth";

export default function useIsAdmin() {
    const auth = useAuth();

    return auth?.user?.admin === true;
}