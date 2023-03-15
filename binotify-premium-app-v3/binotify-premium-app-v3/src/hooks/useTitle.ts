import { useEffect } from "react";

const useTitle = (title: string)  => {
  useEffect(() => {
    document.title = title + " - Binotify Premium App"
  })
}

export default useTitle