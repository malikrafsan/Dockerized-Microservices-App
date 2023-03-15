const onOpenSidebar = () => {
  const sidebar = document.getElementsByClassName('sidebar')[0];
  const openSidebarBtn = document.getElementsByClassName('open-sidebar-btn')[0];
  const closeSidebarBtn = document.getElementsByClassName('close-sidebar-btn')[0];

  sidebar.style.height = '100%';
  openSidebarBtn.setAttribute("hidden", true);
  closeSidebarBtn.removeAttribute("hidden");
}

const onCloseSidebar = () => {
  const sidebar = document.getElementsByClassName('sidebar')[0];
  const openSidebarBtn = document.getElementsByClassName('open-sidebar-btn')[0];
  const closeSidebarBtn = document.getElementsByClassName('close-sidebar-btn')[0];
  
  sidebar.style.height = '0';
  openSidebarBtn.removeAttribute("hidden");
  closeSidebarBtn.setAttribute("hidden", true);
}
